<?php

namespace AppBundle\Form;

use AppBundle\Entity\Models;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ModelType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', TextType::class, array('label' => 'Titre'))
                ->add('description', TextareaType::class, array('required' => false))
                ->add('plans', TextType::class, array('required' => false))
                ->add('imageindir', FileType::class, array('label' => 'Image', 'required' => false, 'mapped' => false))
                ->add('properties', TextType::class, array('label' => 'Propriétés', 'required' => false, 'attr' => array('placeholder' => '{"surface":"125 m²","bedrooms":"5 pièces"}')))
                ->add('save', SubmitType::class, array('label' => 'Valider'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Models::class,
            'allow_extra_fields' => true
        ));
    }

}
