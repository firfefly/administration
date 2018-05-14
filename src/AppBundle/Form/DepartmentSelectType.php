<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class DepartmentSelectType extends AbstractType
{
    private $activeDepartmentsIdAndName;
    private $inactiveDepartmentsIdAndName;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->activeDepartmentsIdAndName = $options['retrieveActiveDepartmentsNameAndCode'];
        $this->inactiveDepartmentsIdAndName = $options['retrieveInactiveDepartmentsNameAndCode'];

        $builder
            ->add('code', ChoiceType::class, array(
                'label' => 'choisissez un département',
                'choices' => array(
                    'départements actifs :' => $this->activeDepartmentsIdAndName,
                    'départements inactifs :' => $this->inactiveDepartmentsIdAndName,
                    ),
                ))
            ->add('save', SubmitType::class, array('label' => 'chercher'))
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null,
            'retrieveActiveDepartmentsNameAndCode' => null,
            'retrieveInactiveDepartmentsNameAndCode' => null,
        ));
    }
}