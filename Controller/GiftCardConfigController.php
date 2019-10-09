<?php
/*************************************************************************************/
/*      Copyright (c) BERTRAND TOURLONIAS                                            */
/*      email : btourlonias@openstudio.fr                                            */
/*************************************************************************************/

namespace TheliaGiftCard\Controller;

use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Event\PdfEvent;
use Thelia\Core\Event\TheliaEvents;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Model\ConfigQuery;
use Thelia\Tools\URL;
use TheliaGiftCard\Model\GiftCard;
use TheliaGiftCard\Model\GiftCardQuery;
use TheliaGiftCard\Service\GiftCardService;
use TheliaGiftCard\TheliaGiftCard;
use TheliaGiftCard\Model\GiftCardInfoCart;

class GiftCardConfigController extends BaseAdminController
{
    public function editConfigAction()
    {
        if (null === $this->checkAdmin()) {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/modules'));
        }

        $form = $this->createForm('config.card.gift');

        try {

            $configForm = $this->validateForm($form);

            $categoryId = $configForm->get('gift_card_category')->getData();
            $orderStatusId = $configForm->get('gift_card_paid_status')->getData();
            $modeId = $configForm->get('gift_card_mode')->getData();

            ConfigQuery::write(TheliaGiftCard::GIFT_CARD_CATEGORY_CONF_NAME, $categoryId, false, true);
            ConfigQuery::write(TheliaGiftCard::GIFT_CARD_ORDER_STATUS_CONF_NAME, $orderStatusId, false, true);
            ConfigQuery::write(TheliaGiftCard::GIFT_CARD_MODE_CONF_NAME, $modeId, false, true);

        } catch (FormValidationException $error_message) {

            $error_message = $error_message->getMessage();
            $form->setErrorMessage($error_message);
            $this->getParserContext()
                ->addForm($form)
                ->setGeneralError($error_message);
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl($form->getSuccessUrl()));
    }

    public function generatePdfAction()
    {
        if (null === $this->checkAdmin()) {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/modules'));
        }

        $code = $this->getRequest()->query->get('code');
        $locale = $this->getRequest()->query->get('l');

        /** @var GiftCardService $giftCardService */
        $giftCardService = $this->container->get('giftcard.service');

        $infos = $giftCardService->getInfoGiftCard($code);

        if (false === $infos) {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/TheliaGiftCard'));
        }

        $html = $this->renderRaw(
            'giftCard',
            array(
                'message' => $infos['message'],
                'code' => $infos['code'],
                'SNAME' => $infos['sponsorName'],
                'BNAME' => $infos['beneficiaryName'],
                'AMOUNT' => $infos['amount'],
                'default_locale' => $locale
            ),
            $this->getTemplateHelper()->getActivePdfTemplate()
        );

        $pdfEvent = new PdfEvent($html);

        $this->dispatch(TheliaEvents::GENERATE_PDF, $pdfEvent);

        if ($pdfEvent->hasPdf()) {
            return $this->pdfResponse($pdfEvent->getPdf(), 'gift_card', 200, true);
        }
    }

    public function generateGiftCardAction()
    {
        if (null === $this->checkAdmin()) {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/modules'));
        }

        $form = $this->createForm('info.add.card.gift');

        $giftCardForm = $this->validateForm($form);

        try {
            $expirationDate = $giftCardForm->get('expiration_date')->getData();

            $newGiftCard = new GiftCard();
            $newGiftCard
                ->setCode(TheliaGiftCard::GENERATE_CODE())
                ->setAmount($giftCardForm->get('amount')->getData())
                ->setExpirationDate($expirationDate->format('Y-m-d'));

            if (0 == TheliaGiftCard::getGiftCardModeId()) {
                $newGiftCard->setStatus(1);
            } else {
                $newGiftCard->setStatus(0);
            }

            $newGiftCard->save();

            $giftCardInfo = new GiftCardInfoCart();

            $giftCardInfo
                ->setGiftCardId($newGiftCard->getId())
                ->setBeneficiaryName($giftCardForm->get('beneficiary_name')->getData())
                ->setSponsorName($giftCardForm->get('sponsor_name')->getData())
                ->setBeneficiaryMessage($giftCardForm->get('beneficiary_message')->getData())
                ->save();

        } catch (FormValidationException $error_message) {

            $error_message = $error_message->getMessage();
            $form->setErrorMessage($error_message);
            $this->getParserContext()
                ->addForm($form)
                ->setGeneralError($error_message);
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl($form->getSuccessUrl()));

    }

    public function activateGiftCardAction($codeGC)
    {
        if (null === $this->checkAdmin()) {
            return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/modules'));
        }

        $giftCard = GiftCardQuery::create()
            ->filterByCode($codeGC)
            ->filterByStatus(0)
            ->findOne();

        if ($giftCard) {
            $giftCard->setStatus(1)
                ->save();
        }

        return $this->generateRedirect(URL::getInstance()->absoluteUrl('/admin/module/TheliaGiftCard'));
    }

    protected function checkAdmin()
    {
        return $test = $this->getSecurityContext()->hasAdminUser();
    }
}