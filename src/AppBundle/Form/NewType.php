<?php

namespace AppBundle\Form;

use AppBundle\Entity\News;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class NewType extends AbstractType
{
    private $departmentsIdAndName;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->departmentsIdAndName = $options['departmentsIdAndName'];

        $builder
                ->add('department', ChoiceType::class, array(
                        'label' => 'Département',
                        'choices' => $this->departmentsIdAndName,
                        'required' => false,
                        ))
                ->add('title', TextType::class, array('label' => 'Titre'))
                ->add('caption', TextType::class, array('label' => 'Légende'))
                ->add('text', TextareaType::class, array('label' => 'Texte'))
                ->add('image', FileType::class, array('label' => 'Image', 'data_class' => null, 'required' => false))
                ->add('active', CheckboxType::class, array('label' => 'Visibilité', 'required' => false))
                ->add('date', DateType::class, array('label' => 'Date', 'format' => 'dd-MM-yyyy', 'widget' => 'single_text'))
                ->add('save', SubmitType::class, array('label' => 'Valider'))
                ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => News::class,
            'departmentsIdAndName' => null,
        ));
    }
}