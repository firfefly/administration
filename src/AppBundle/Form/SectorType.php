<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use AppBundle\Entity\Sectors;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SectorType extends AbstractType
{
    private $retrieveAgenciesIdAndName;
    private $selected;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->retrieveAgenciesIdAndName = $options['retrieveAgenciesIdAndName'];
        $this->selected = $options['selected'];

        $builder
                ->add('code',TextType::class)
                ->add('agencyId',ChoiceType::class, array(
                        'label' => "code de l'agence",
                        'choices' => $this->retrieveAgenciesIdAndName,
                        'preferred_choices' => $this->selected,
                        ))
                ->add('save', SubmitType::class, array('label' => 'Valider'))
                    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'retrieveAgenciesIdAndName' => null,
            'selected' => null,
            'data_class' => Sectors::class,
        ));
    }
}