<?php
/*************************************************************************************/
/*      Copyright (c) BERTRAND TOURLONIAS                                            */
/*      email : btourlonias@openstudio.fr                                            */
/*************************************************************************************/

namespace TheliaGiftCard\Form;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use TheliaGiftCard\TheliaGiftCard;

class InfoAddCGForm extends InfoCGBaseForm
{
    public function getName()
    {
        return 'info_add_card_gift';
    }

    protected function buildForm()
    {
        parent::buildForm();

        $this->formBuilder
            ->add(
                'amount',
                NumberType::class,
                [
                    'label' => $this->translator->trans('FORM_ADD_AMOUNT_GC', [], TheliaGiftCard::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => $this->getName() . '-label'
                    ]
                ])
            ->add(
                'expiration_date',
                DateType::class,
                [
                    'widget' => 'single_text',
                    'label' => $this->translator->trans('FORM_ADD_EXPIRATION_GC', [], TheliaGiftCard::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => $this->getName() . '-label'
                    ]
                ])
        ;

    }
}