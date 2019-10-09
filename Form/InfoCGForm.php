<?php
/*************************************************************************************/
/*      Copyright (c) BERTRAND TOURLONIAS                                            */
/*      email : btourlonias@openstudio.fr                                            */
/*************************************************************************************/

namespace TheliaGiftCard\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use TheliaGiftCard\TheliaGiftCard;

class InfoCGForm extends InfoCGBaseForm
{
    public function getName()
    {
        return 'info_card_gift';
    }

    protected function buildForm()
    {
        parent::buildForm();

        $this->formBuilder
            ->add(
                'product_id',
                TextType::class,
                [
                    'label' => $this->translator->trans('FORM_ADD_SPONSOR_NAME', [], TheliaGiftCard::DOMAIN_NAME),
                    'label_attr' => [
                        'for' => $this->getName() . '-label'
                    ]
                ])
        ;

    }
}