<?php

namespace AppBundle\Form;

use AppBundle\Entity\Sliders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SliderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('image', FileType::class, array('data_class' => null, 'required' => false))
                ->add('alt', TextType::class)
                ->add('slogan', TextType::class)
                ->add('title', TextType::class, array('label' => 'Titre'))
                ->add('text', TextareaType::class, array('label' => 'Texte'))
                ->add('actionLink1', TextType::class, array('label' => 'Lien du bouton 1'))
                ->add('actionText1', TextType::class, array('label' => 'Texte du bouton 1'))
                ->add('actionLink2', TextType::class, array('label' => 'Lien du bouton 2'))
                ->add('actionText2', TextType::class, array('label' => 'Texte du bouton 2'))
                ->add('save', SubmitType::class, array('label' => 'Valider'))
                ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Sliders::class,
        ));
    }
}