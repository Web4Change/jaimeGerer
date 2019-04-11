<?php

namespace AppBundle\Form\TimeTracker;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TempsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {



        $builder
            ->add('monthpicker', 'text', array(
                'attr' => array('class' => 'monthInput', 'autocomplete' => 'off'),
                'required' => true,
                'label' => 'Date',
                'mapped' => false,
                'data' => date('m/Y')
            ))
            ->add('date', 'date', array(
                'widget' => 'single_text',
                'input' => 'datetime',
                'attr' => array('class' => 'hidden'),
                'label_attr' => array('class' => 'hidden'),
            ))
            ->add('duree', 'number', array(
                'required' => true,
                'label' => 'Temps passé'
            ))
            ->add('activite', 'text', array(
                'required' => false,
                'label' => 'Activité'
            ))
            ->add('projet_name', 'text', array(
                'required' => true,
                'mapped' => false,
                'label' => 'Projet',
                'attr' => array('class' => 'typeahead-projet', 'autocomplete' => 'off')
            ))
            ->add('projet_entity', 'hidden', array(
                'required' => true,
                'attr' => array('class' => 'entity-projet'),
                'mapped' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\TimeTracker\Temps'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_timetracker_temps';
    }
}
