<?php

namespace AppBundle\Form;

use AppBundle\Entity\Reviews;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ReviewType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('text', TextareaType::class, array('label' => 'Texte'))
                ->add('who', TextType::class, array('label' => 'Qui ?'))
                ->add('image1', FileType::class, array('label' => 'Image 1', 'data_class' => null, 'required' => false))
                ->add('image2', FileType::class, array('label' => 'Image 2', 'data_class' => null, 'required' => false))
                ->add('date', DateType::class, array('label' => 'Date', 'format' => 'dd-MM-yyyy'))
                ->add('mark', NumberType::class, array('label' => 'Notes'))
                ->add('save', SubmitType::class, array('label' => 'Valider'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Reviews::class,
        ));
    }

}
