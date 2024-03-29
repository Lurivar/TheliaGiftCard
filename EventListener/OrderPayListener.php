<?php
/*************************************************************************************/
/*      Copyright (c) BERTRAND TOURLONIAS                                            */
/*      email : btourlonias@openstudio.fr                                            */
/*************************************************************************************/

namespace TheliaGiftCard\EventListener;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Core\Event\Cart\CartItemDuplicationItem;
use Thelia\Core\Event\Order\OrderEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Model\CartItem;
use Thelia\Model\CartItemQuery;
use Thelia\Model\CartQuery;
use Thelia\Model\FeatureProductQuery;
use Thelia\Model\Order;
use Thelia\Model\ProductSaleElementsQuery;
use TheliaGiftCard\Model\GiftCard;
use TheliaGiftCard\Model\GiftCardCart;
use TheliaGiftCard\Model\GiftCardCartQuery;
use TheliaGiftCard\Model\GiftCardInfoCart;
use TheliaGiftCard\Model\GiftCardInfoCartQuery;
use TheliaGiftCard\Model\GiftCardOrderQuery;
use TheliaGiftCard\Model\GiftCardQuery;
use TheliaGiftCard\Service\GiftCardAmountSpendService;
use TheliaGiftCard\Service\GiftCardService;
use TheliaGiftCard\TheliaGiftCard;

class OrderPayListener implements EventSubscriberInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Request
     */
    private $request;

    public function __construct(Container $container, Request $request)
    {
        $this->container = $container;
        $this->request = $request;
    }

    public function creatCodeGiftCard(OrderEvent $event)
    {
        if ($event->getOrder()->getStatusId() == TheliaGiftCard::getGiftCardOrderStatusId()) {

            /** @var Order $order */
            $order = $event->getOrder();

            $countMaxbyAmount = $this->getCountGiftCards($order->getOrderProducts());

            /** @var  CartItem $item */
            foreach ($order->getOrderProducts() as $orderProduct) {
                $pse = ProductSaleElementsQuery::create()->findPk($orderProduct->getProductSaleElementsId());

                $productId = $pse->getProduct()->getId();

                $tabProductGiftCard =  TheliaGiftCard::getGiftCardProductList();

                if (in_array($productId, $tabProductGiftCard)) {

                    $orederId = $order->getId();

                    $price = $orderProduct->getPrice();

                    $orderProductTaxes = $orderProduct->getOrderProductTaxes()->getData();

                    foreach ($orderProductTaxes as $orderProductTax) {
                        $TaxAmount = $orderProductTax->getAmount();
                    }

                    for ($i = 1; $i <= $orderProduct->getQuantity(); $i++) {

                        $expirationDate = new \DateTime("+12 months");

                        $giftCards = GiftCardQuery::create()
                            ->filterByOrderId($order->getId())
                            ->filterByProductId($productId)
                            ->find();

                        if ($giftCards->count() < $countMaxbyAmount[$productId]) {
                            $amount = $price + $TaxAmount;

                            $featureAmount = FeatureProductQuery::create()
                                ->filterByProductId($productId)
                                ->filterByFreeTextValue(1)
                                ->findOne();

                            if(null !== $featureAmount){
                                $amount = (float) $featureAmount->getFeatureAv()->setLocale('fr_FR')->getTitle();
                            }

                            $newGiftCard = new GiftCard();
                            $newGiftCard
                                ->setProductId($productId)
                                ->setSponsorCustomerId($order->getCustomer()->getId())
                                ->setOrderId($orederId)
                                ->setCode(TheliaGiftCard::GENERATE_CODE())
                                ->setAmount($amount)
                                ->setExpirationDate($expirationDate);

                            if(0 == TheliaGiftCard::getGiftCardModeId()){
                                $newGiftCard->setStatus(1);
                            }  else {
                                $newGiftCard->setStatus(0);
                            }

                            $newGiftCard->save();
                        }

                        $giftCardInfo = GiftCardInfoCartQuery::create()
                                ->filterByOrderProductId($orderProduct->getId())
                                ->findOne();

                        if($giftCardInfo){
                            $giftCardInfo
                                ->setGiftCardId($newGiftCard->getId())
                                ->save();
                        }
                    }
                }
            }
        }
    }

    public function setCardAmountOnOrder(OrderEvent $event)
    {
        $cart = $this->request->getSession()->getSessionCart();

        /** @var GiftCardService $gcservice */
        $gcservice = $this->container->get('giftcard.service');

        $order = $event->getPlacedOrder();

        $orderCardGift = GiftCardOrderQuery::create()->filterByOrderId($order->getId())->findOne();

        if($orderCardGift) {
            $order
                ->setPostage($orderCardGift->getInitialPostage())
                ->setDiscount($orderCardGift->getInitialDiscount())
                ->save();
        }

        $datasGC = GiftCardCartQuery::create()->filterByCartId($cart->getId())->find();

        /** @var GiftCardCart $dataGC */
        foreach ($datasGC as $dataGC) {
            $gcservice->setGiftCardAmount($dataGC->getGiftCardId(), $dataGC->getSpendAmount() + $dataGC->getSpendDelivery(), $cart->getCustomer()->getId());
            $datasGC->delete();
        }
    }

    public function onOrderPayGiftCard(OrderEvent $event)
    {
        /** @var Order $order */
        $order = $event->getPlacedOrder();

        $cartId = $this->request->getSession()->getSessionCart()->getId();

        $cartNewGiftCards = GiftCardInfoCartQuery::create()
            ->filterByCartId($cartId)
            ->find();

        $exclude = [];

        /** @var GiftCardInfoCart $cartGiftCard */
        foreach ($cartNewGiftCards as $cartGiftCard) {

            if ($cartGiftCard) {
                $cartProduct = CartItemQuery::create()->findPk($cartGiftCard->getCartItemId());

                foreach ($order->getOrderProducts() as $orderProduct) {

                    $orderProductCurrent = $orderProduct->getProductSaleElementsId();

                    if ($cartProduct->getProductSaleElementsId() == $orderProductCurrent &&
                        !in_array($orderProduct->getId(), $exclude) && !in_array($cartGiftCard->getId(), $exclude)) {

                        $cartNewCustom = GiftCardInfoCartQuery::create()
                            ->filterByCartId($cartId)
                            ->filterByCartItemId($cartGiftCard->getCartItemId())
                            ->findOne();

                        $cartNewCustom
                                ->setOrderProductId($orderProduct->getId())
                                ->save();

                        $exclude[] = $orderProduct->getId();
                        $exclude[] = $cartGiftCard->getId();
                    }
                }
            }
        }
    }

    public function setAmountOnOrder(OrderEvent $event)
    {
        $order = $event->getOrder();
        $cart = CartQuery::create()->findPk($order->getCartId());

        if ($cart) {

            /** @var  GiftCardAmountSpendService $giftCardService */
            $giftCardService = $this->container->get('giftcard.amount.spend.service');
            $totalGiftCardAmount = $giftCardService->calculTotalGCDelievery($this->request->getSession()->getSessionCart());

            /** @var GiftCardService $gcservice */
            $gcservice = $this->container->get('giftcard.service');


            if (0 < $totalGiftCardAmount) {

                $totalPriceCart = $giftCardService->getTotalPriceOrder($cart);
                $totalOrderPrice = $totalPriceCart + $order->getPostage() - $order->getDiscount();

                $initialPostage = $order->getPostage();
                $initialDiscount = $order->getDiscount();

                if ($totalGiftCardAmount == $totalOrderPrice) {
                    $order->setPostage(0);
                    $order->setDiscount($totalGiftCardAmount);
                } else {
                    if ($totalGiftCardAmount <= $totalPriceCart) {
                        $order->setDiscount($totalGiftCardAmount);
                    } else {
                        $delta = $totalGiftCardAmount - $totalPriceCart;
                        $order->setDiscount($totalPriceCart);
                        $order->setPostage($order->getPostage() - $delta);
                    }
                }

                $datasGC = GiftCardCartQuery::create()->filterByCartId($cart->getId())->find();

                /** @var GiftCardCart $dataGC */
                foreach ($datasGC as $dataGC) {
                    $gcservice->setOrderAmountGC($order->getId(), $totalGiftCardAmount, $dataGC->getGiftCardId(), $cart->getCustomer()->getId(),$initialDiscount,$initialPostage);
                }

                $order->save();

                return $order;
            }
        }
    }

    public function duplicateCartGiftCardInfo(CartItemDuplicationItem $cartEvent)
    {
        /** @var CartItem $oldItem */
        $oldItem = $cartEvent->getOldItem();
        $oldCartId = $oldItem->getCartId();

        /** @var CartItem $oldItem */
        $newItem = $cartEvent->getNewItem();
        $newCartId = $newItem->getCartId();

        $oldItem = $oldItem->getId();
        $newItem = $newItem->getId();

        $cartInfoGC = GiftCardInfoCartQuery::create()
            ->filterByCartId($oldCartId)
            ->filterByCartItemId($oldItem)
            ->findOne();

        if ($cartInfoGC) {
            $cartInfoGC->setCartId($newCartId);
            $cartInfoGC->setCartItemId($newItem);
            $cartInfoGC->save();
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::ORDER_UPDATE_STATUS => ['creatCodeGiftCard', 128],
            TheliaEvents::ORDER_PAY => ['onOrderPayGiftCard', 64],
            TheliaEvents::ORDER_BEFORE_PAYMENT => ['setAmountOnOrder', 128],
            TheliaEvents::CART_ITEM_DUPLICATE => ['duplicateCartGiftCardInfo', 250]
        ];
    }

    private function getCountGiftCards($orderProducts)
    {
        $cpt = [];

        foreach ($orderProducts as $orderProduct) {
            $pse = ProductSaleElementsQuery::create()->findPk($orderProduct->getProductSaleElementsId());

            $productId = $pse->getProduct()->getId();

            $tabProductGiftCard =  TheliaGiftCard::getGiftCardProductList();

            if (in_array($productId, $tabProductGiftCard)) {

                if (isset($cpt[$productId])) {
                    $cpt[$productId] += $orderProduct->getQuantity();
                } else {
                    $cpt[$productId] = $orderProduct->getQuantity();
                }
            }
        }

        return $cpt;
    }
}