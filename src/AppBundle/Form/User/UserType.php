<?php

namespace AppBundle\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType
{

    protected $companyId;

    public function __construct ($companyId = null)
    {
        $this->companyId = $companyId;
    }
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('firstName', 'text', array(
                'required' => true,
                'label' => 'Prénom'
            ))
            ->add('lastName', 'text', array(
                'required' => true,
                'label' => 'Nom'
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label' => 'Adresse email'
            ))
            ->add('enabled', 'checkbox', array(
                'required' => false,
                'label' => ' ',
                'attr' => array(
                    'data-toggle'=> "toggle",
                    'data-onstyle'=> "success",
                    'data-offstyle'=> "danger",
                    'data-on'=> "Oui",
                    'data-off'=> "Non"
                )
            ))
            ->add('admin', 'checkbox', array(
                'required' => false,
                'label' => ' ',
                'mapped' => false,
                'attr' => array(
                    'data-toggle'=> "toggle",
                    'data-onstyle'=> "success",
                    'data-offstyle'=> "danger",
                    'data-on'=> "Oui",
                    'data-off'=> "Non"
                )
            ))
            ->add('permissions', 'choice', array(
                'mapped' => false,
                'multiple' => true,
                'expanded' => true,
                'label' => 'Peut utiliser :',
                'choices' => array(
                    'ROLE_COMMERCIAL' => 'J\'aime le commercial',
                    'ROLE_COMPTA' => 'J\'aime la compta',
                    'ROLE_COMMUNICATION' => 'J\'aime communiquer',
                    //'ROLE_RH' => 'J\'aime le recrutement',
                    'ROLE_NDF' => 'J\'aime les notes de frais',
                    'ROLE_TIMETRACKER' => 'J\'aime compter mon temps',
                )
            ))
            ->add('tauxHoraire', 'integer', array(
                'required' => false,
                'label' => 'Taux horaire'
            ))
            ->add('compteComptableNoteFrais', 'entity', array(
                'class'=>'AppBundle:Compta\CompteComptable',
                'required' => false,
                'label' => 'Compte comptable pour les notes de frais',
                'property' => 'nom',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                      ->where('c.company = :company')
                      ->andWhere('c.num LIKE :num')
                      ->setParameter('company', $this->companyId)
                      ->setParameter('num', '62510%')
                      ->orderBy('c.nom', 'ASC');
                },
            ))
            ->add('modeleVoiture', 'text', array(
                'required' => false,
                'label' => 'Modèle'
            ))
            ->add('marqueVoiture', 'text', array(
                'required' => false,
                'label' => 'Marque'
            ))
            ->add('immatriculationVoiture', 'text', array(
                'required' => false,
                'label' => 'Immatriculation'
            ))
            ->add('puissanceVoiture', 'choice', array(
                'required' => false,
                'label' => 'Puissance fiscale',
                'choices' => array(
                    3 => '3 CV',
                    4 => '4 CV',
                    5 => '5 CV',
                    6 => '6 CV',
                    7 => '7 CV et plus'
                )
            ))
            ->add('submit', 'submit', array(
              'label' => 'Enregistrer',
              'attr' => array('class' => 'btn btn-success')
            ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
}
