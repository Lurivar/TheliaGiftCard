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
use Thelia\Model\Map\CustomerTableMap;
use TheliaGiftCard\Model\GiftCardCustomer;
use TheliaGiftCard\Model\GiftCardInfoCart;
use TheliaGiftCard\Model\GiftCardInfoCartQuery;
use TheliaGiftCard\Model\GiftCardQuery;
use TheliaGiftCard\Model\Map\GiftCardCustomerTableMap;
use TheliaGiftCard\Model\Map\GiftCardTableMap;


class GiftCArdListSponsor extends BaseLoop implements PropelSearchLoopInterface
{
    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createAlphaNumStringTypeArgument('customer_id', null),
            Argument::createIntTypeArgument('card_id', null),
            Argument::createIntTypeArgument('status', null)
        );
    }

    public function buildModelCriteria()
    {
        $customerId = $this->getCustomerId();
        $cardId = $this->getCardId();
        $status = $this->getStatus();

        $search = GiftCardQuery::create();

        $cardGiftCustomerJoin = new Join(
            GiftCardTableMap::ID,
            GiftCardCustomerTableMap::CARD_ID,
            Criteria::LEFT_JOIN
        );

        $search->addJoinObject($cardGiftCustomerJoin, 'cardGiftCustomerJoin');

        $customerJoin = new Join(
            GiftCardTableMap::SPONSOR_CUSTOMER_ID,
            CustomerTableMap::ID,
            Criteria::LEFT_JOIN
        );

        $search->addJoinObject($customerJoin, 'customerJoin');

        $search->withColumn(
            GiftCardTableMap::EXPIRATION_DATE, 'expiration_date'

        );

        $search->withColumn(
            GiftCardCustomerTableMap::TABLE_NAME . '.' . 'used_amount', 'used_amount'

        );

        $search->withColumn(
            GiftCardCustomerTableMap::TABLE_NAME . '.' . 'customer_id', 'customer_id'

        );

        $search->withColumn(
            CustomerTableMap::TABLE_NAME . '.' . 'firstname', 'sponsor_firstname'

        );

        $search->withColumn(
            CustomerTableMap::TABLE_NAME . '.' . 'lastname', 'sponsor_lastname'

        );

        if ($customerId === 'current') {
            $currentCustomer = $this->securityContext->getCustomerUser();
            if (null === $currentCustomer) {
                return null;
            } else {
                $search->filterBySponsorCustomerId($currentCustomer->getId(), Criteria::EQUAL);
            }
        } else {
            if ($customerId !== null) {
                $search->filterBySponsorCustomerId($customerId);
            }
        }

        if ($cardId !== null) {
            $search->filterById($cardId);
        }

        if ($status !== null) {
            $search->filterByStatus($status);
        }

        return $search;
    }

    public function parseResults(LoopResult $loopResult)
    {
        /** @var GiftCardCustomer $giftCard */
        foreach ($loopResult->getResultDataCollection() as $giftCard) {

            $customer = $giftCard->getCustomer();

            $firstname = "";
            $lastname = "";

            if ($customer) {
                $firstname = $giftCard->getCustomer()->getFirstname();
                $lastname = $giftCard->getCustomer()->getLastname();
            } else {
                $infos = GiftCardInfoCartQuery::create()->filterByGiftCardId($giftCard->getId())->findOne();

                if ($infos) {
                    $firstname = $infos->getBeneficiaryName();
                }
            }

            $loopResultRow = (new LoopResultRow($giftCard))
                ->set('ID', $giftCard->getId())
                ->set('AMOUNT', $giftCard->getAmount())
                ->set('USED_AMOUNT', $giftCard->getVirtualColumn('used_amount'))
                ->set('CODE', $giftCard->getCode())
                ->set('FIRSTNAME', $firstname)
                ->set('LASTNAME', $lastname)
                ->set('STATUS', $giftCard->getStatus())
                ->set('EXPDATE', $giftCard->getVirtualColumn('expiration_date'))
                ->set('CUSTOMER_ID', $giftCard->getVirtualColumn('customer_id'));


            if ($customerID = $giftCard->getVirtualColumn('customer_id')) {
                $customer = CustomerQuery::create()->findPk($customerID);

                if (null !== $customer) {
                    $loopResultRow->set('USER_NAME', $customer->getLastname() . ' ' . $customer->getFirstname());
                }
            } else {
                $loopResultRow->set('USER_NAME', 0);
            }

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}