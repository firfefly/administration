<?php

// src/AppBundle/Form/RegistrationType.php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
//        parent::buildForm($builder, $options);
        $builder
                ->add('roles', CollectionType::class, array(
                    'entry_type' => ChoiceType::class,
                    'entry_options' => array(
                        'label' => false,
                        'choices' => array(
                            'Admin' => 'ROLE_ADMIN',
                            'Communication' => 'ROLE_COMMUNICATION',
                            'Commercial' => 'ROLE_COMMERCIAL',
                            'WebMarketing' => 'ROLE_WEBMARKETING',
                        ),
                    )
        ));
    }

    public function getParent() {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';
    }

    public function getBlockPrefix() {
        return 'app_user_registration';
    }

    public function getName() {
        return $this->getBlockPrefix();
    }

}
