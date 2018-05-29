<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Brands;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class BrandType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('brands', EntityType::class, array(
                    'class' => Brands::class,
                    'choice_label' => 'name',
                    'label' => 'Choisissez une marque :'
                ))
                ->add('save', SubmitType::class, array('label' => 'Valider', 'attr' => ['class' => 'btn']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
        ));
    }

}
