<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Agencies;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AgencyType extends AbstractType
{
    private $retrieveDepartmentsIdAndName;
    private $selected;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->retrieveDepartmentsIdAndName = $options['retrieveDepartmentsIdAndName'];
        $this->selected = $options['selected'];

        $builder
                ->add('latitude',TextType::class)
                ->add('longitude',TextType::class)
                ->add('name',TextType::class, array('label' => 'Nom'))
                ->add('zip_code',TextType::class)
                ->add('city',TextType::class, array('label' => 'Ville'))
                ->add('department_code',ChoiceType::class, array(
                        'label' => 'code du département',
                        'choices' => $this->retrieveDepartmentsIdAndName,
                        'preferred_choices' => $this->selected,
                        ))
                ->add('address',TextType::class, array('label' => 'Adresse'))
                ->add('phoneNumber',TextType::class, array('label' => 'Numéro de téléphone'))
                ->add('email',TextType::class, array('required' => false))
                ->add('schedule',TextareaType::class, array('label' => 'Horaires', 'attr' => array('placeholder' => 'du lundi au vendredi de 9h à 12h et de 14h à 18h')))
                ->add('next_to',TextType::class, array('label' => 'À côté de', 'required' => false))
                ->add('caption',TextType::class, array('label' => 'Légende', 'required' => false))
                ->add('description',TextType::class, array('required' => false))
                ->add('save', SubmitType::class, array('label' => 'Valider'))
                    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'retrieveDepartmentsIdAndName' => null,
            'selected' => null,
            'data_class' => Agencies::class,
        ));
    }
}