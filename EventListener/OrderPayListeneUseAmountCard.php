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
use Thelia\Core\Event\Order\OrderPaymentEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Core\HttpFoundation\Request;
use Thelia\Model\CartItem;
use Thelia\Model\CartItemQuery;
use Thelia\Model\CartQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\Order;
use Thelia\Model\ProductCategory;
use Thelia\Model\ProductCategoryQuery;
use Thelia\Model\ProductSaleElementsQuery;
use TheliaGiftCard\Model\GiftCard;
use TheliaGiftCard\Model\GiftCardCart;
use TheliaGiftCard\Model\GiftCardCartQuery;
use TheliaGiftCard\Model\GiftCardCustomerQuery;
use TheliaGiftCard\Model\GiftCardInfoCart;
use TheliaGiftCard\Model\GiftCardInfoCartQuery;
use TheliaGiftCard\Model\GiftCardOrder;
use TheliaGiftCard\Model\GiftCardOrderQuery;
use TheliaGiftCard\Model\GiftCardQuery;
use TheliaGiftCard\Service\GiftCardAmountSpendService;
use TheliaGiftCard\Service\GiftCardService;
use TheliaGiftCard\TheliaGiftCard;

class OrderPayListeneUseAmountCard implements EventSubscriberInterface
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


    public function setCardAmountOnOrder(OrderEvent $event)
    {
        $cart = $this->request->getSession()->getSessionCart();

        /** @var GiftCardService $gcservice */
        $gcservice = $this->container->get('giftcard.service');

        $order = $event->getPlacedOrder();

        $orderCardGift = GiftCardOrderQuery::create()->filterByOrderId($order->getId())->findOne();

        if (false) {
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

    public function resetCardAmountOnOrder(OrderEvent $event)
    {
        if ($event->getOrder()->getStatusId() == 5) {
            $catOrders = GiftCardOrderQuery::create()
                ->filterByOrderId($event->getOrder()->getId())
                ->find();

            /** @var GiftCardOrder $catOrder */
            foreach ($catOrders as $catOrder) {
                $cardid = $catOrder->getGiftCardId();

                $customerCard = GiftCardCustomerQuery::create()
                    ->filterByCardId($cardid)
                    ->filterByCustomerId($event->getOrder()->getCustomerId())
                    ->findOne();

                if (null !== $customerCard) {

                    $usedAmout = $customerCard->getUsedAmount() - $catOrder->getSpendAmount();

                    if(0 > $usedAmout || 0 < $usedAmout){
                        $usedAmout = 0;
                    }

                    $customerCard
                        ->setUsedAmount($usedAmout)
                        ->save();
                }

                $catOrder->delete();
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            TheliaEvents::ORDER_PAY => ['setCardAmountOnOrder', 128],
            TheliaEvents::ORDER_UPDATE_STATUS => ['resetCardAmountOnOrder', 128],
        ];
    }
}