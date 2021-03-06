<?php

namespace AppBundle\Form\CRM;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanPaiementType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $planPaiement = $builder->getData();

        $builder
            ->add('pourcentage', 'number', array(
                'attr' => array('class' => 'percent'),
                'required' => false,
            ))
            ->add('nom', 'text', array(
            ))
            ->add('date', 'date', array('widget' => 'single_text',
                'input' => 'datetime',
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'dateInput'),
                'required' => true,
                'label' => 'Date',
            ))
            ->add('montant', 'number', array(
                'attr' => array('class' => 'montant-euro'),
                'required' => false,
            ));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CRM\PlanPaiement'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_crm_planpaiement';
    }
}
