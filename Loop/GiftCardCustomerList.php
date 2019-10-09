<?php
/*************************************************************************************/
/*      Copyright (c) BERTRAND TOURLONIAS                                            */
/*      email : btourlonias@openstudio.fr                                            */
/*************************************************************************************/

namespace TheliaGiftCard\Loop;


use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\Join;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Model\CustomerQuery;
use Thelia\Model\Map\ProductI18nTableMap;
use TheliaGiftCard\Model\GiftCard;
use TheliaGiftCard\Model\GiftCardCart;
use TheliaGiftCard\Model\GiftCardCartQuery;
use TheliaGiftCard\Model\GiftCardCustomer;
use TheliaGiftCard\Model\GiftCardCustomerQuery;
use TheliaGiftCard\Model\GiftCardInfoCartQuery;
use TheliaGiftCard\Model\GiftCardOrder;
use TheliaGiftCard\Model\Map\GiftCardCartTableMap;
use TheliaGiftCard\Model\Map\GiftCardCustomerTableMap;
use TheliaGiftCard\Model\Map\GiftCardTableMap;


class GiftCardCustomerList extends BaseLoop implements PropelSearchLoopInterface
{
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createAlphaNumStringTypeArgument('customer_id', null),
            Argument::createIntTypeArgument('card_id', null),
            Argument::createIntTypeArgument('cart_id', null),
            Argument::createIntTypeArgument('expired', null)
        );
    }

    public function buildModelCriteria()
    {
        $customerId = $this->getCustomerId();
        $cardId = $this->getCardId();

        $locale = $this->getCurrentRequest()->getSession()->getLang()->getLocale();

        $search = GiftCardCustomerQuery::create();

        if (0 == $this->getExpired()) {
            $search
                ->useGiftCardQuery()
                ->filterByExpirationDate($dateNow = new \DateTime(), Criteria::GREATER_EQUAL)
                ->useProductQuery("", Criteria::LEFT_JOIN)
                ->useProductI18nQuery()
                ->filterByLocale($locale)
                ->_or()
                ->filterByLocale(null, Criteria::ISNULL)
                ->endUse()
                ->endUse()
                ->endUse();
        } else {
            $search
                ->useGiftCardQuery()
                ->useProductQuery("", Criteria::LEFT_JOIN)
                ->useProductI18nQuery()
                ->filterByLocale($locale)
                ->_or()
                ->filterByLocale(null, Criteria::ISNULL)
                ->endUse()
                ->endUse()
                ->endUse();
        }

        $search->withColumn(GiftCardTableMap::TABLE_NAME . '.' . 'amount', 'amount');
        $search->withColumn(GiftCardTableMap::TABLE_NAME . '.' . 'code', 'code');
        $search->withColumn(GiftCardTableMap::TABLE_NAME . '.' . 'sponsor_customer_id', 'sponsor_customer_id');
        $search->withColumn(GiftCardTableMap::TABLE_NAME . '.' . 'sponsor_customer_id', 'sponsor_customer_id');
        $search->withColumn(GiftCardTableMap::EXPIRATION_DATE, 'expiration_date');
        $search->withColumn(GiftCardTableMap::ID, 'giftcard_id');
        $search->withColumn(ProductI18nTableMap::TABLE_NAME . '.' . 'title', 'product_title');

        if ($customerId === 'current') {
            $currentCustomer = $this->securityContext->getCustomerUser();
            if (null === $currentCustomer) {
                return null;
            } else {
                $search->filterByCustomerId($currentCustomer->getId(), Criteria::EQUAL);
            }
        } else {
            if ($customerId !== null) {
                $search->filterByCustomerId($customerId);
            }
        }

        if ($cardId !== null) {
            $search->filterByCardId($cardId);
        }

        return $search;
    }

    public function parseResults(LoopResult $loopResult)
    {
        $dateNow = new \DateTime();

        /** @var GiftCardCustomer $giftCard */
        foreach ($loopResult->getResultDataCollection() as $giftCard) {

            $dateExpiration = new \DateTime($giftCard->getVirtualColumn('expiration_date'));

            $loopResultRow = (new LoopResultRow($giftCard))
                ->set('ID', $giftCard->getId())
                ->set('USED_AMOUNT', $giftCard->getUsedAmount())
                ->set('DATE', $giftCard->getCreatedAt()->format('d-m-Y'))
                ->set('EXPIREDDATE', $dateExpiration->format('d-m-Y'))
                ->set('INIT_AMOUNT', $giftCard->getVirtualColumn('amount'))
                ->set('CODE', $giftCard->getVirtualColumn('code'))
                ->set('PRODUCT', $giftCard->getVirtualColumn('product_title'))
                ->set('CART_USED_AMOUNT', $this->getCartAmount($giftCard->getCardId(), 3));

            $delta = $dateNow->diff($dateExpiration)->format('%r');

            $loopResultRow->set('EXPIRED', 0);

            if (null != $delta) {
                $loopResultRow->set('EXPIRED', 1);
            }

            $sponsorCustomerID = $giftCard->getVirtualColumn('sponsor_customer_id');
            $sponsorCustomer = CustomerQuery::create()->findPk($sponsorCustomerID);

            if (null !== $sponsorCustomer) {
                $loopResultRow->set('SPONSOR_NAME', $sponsorCustomer->getLastname() . ' ' . $sponsorCustomer->getFirstname());
            } else {
                $infos = GiftCardInfoCartQuery::create()->filterByGiftCardId($giftCard->getVirtualColumn(giftcard_id))->findOne();

                if ($infos) {
                    $loopResultRow->set('SPONSOR_NAME', $infos->getBeneficiaryName());
                }
            }

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }

    protected function getCartAmount($giftCardID, $cartID)
    {
        $total = 0;

        $giftCardsCart = GiftCardCartQuery::create()
            ->filterByGiftCardId($giftCardID)
            ->filterByCartId($cartID)
            ->find();

        /** @var GiftCardCart $giftCardCart */
        foreach ($giftCardsCart as $giftCardCart) {
            $total += $giftCardCart->getSpendAmount();
        }

        return $total;
    }
}