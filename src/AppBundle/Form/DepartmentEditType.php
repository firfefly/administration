<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Departments;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class DepartmentEditType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('code', TextType::class)
                ->add('name', TextType::class, array('label' => 'Nom'))
                ->add('description', TextareaType::class, array('required' => false))
                ->add('short_description', TextareaType::class, array('label' => 'Description courte', 'required' => false))
                ->add('image', FileType::class, array('data_class' => null, 'required' => false))
                ->add('active', CheckboxType::class, array('label' => 'Visibilité', 'required' => false))
                ->add('save', SubmitType::class, array('label' => 'Valider'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'data_class' => Departments::class,
        ));
    }

}
