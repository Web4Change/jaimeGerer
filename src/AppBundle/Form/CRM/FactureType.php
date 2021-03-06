<?php

namespace AppBundle\Form\CRM;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

use AppBundle\Form\CRM\ProduitType;

class FactureType extends AbstractType
{
	protected $userGestionId;
	protected $companyId;
    protected $compte;

	public function __construct ($userGestionId = null, $companyId = null, $compte = null)
	{
		$this->userGestionId = $userGestionId;
		$this->companyId = $companyId;
        $this->compte = $compte;
	}


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $nomFacturation = null;
        $adresse = null;
        $adresseLigne2 = null;
        $codePostal = null;
        $ville = null;
        $pays = null;
        if($this->compte){
            $nomFacturation = $this->compte->getNomFacturation()?$this->compte->getNomFacturation():$this->compte->getNom();
            $adresse = $this->compte->getAdresseFacturation()?$this->compte->getAdresseFacturation():$this->compte->getAdresse();
            $adresseLigne2 = $this->compte->getAdresseFacturationLigne2()?$this->compte->getAdresseFacturationLigne2():'';
            $codePostal = $this->compte->getCodePostalFacturation()?$this->compte->getCodePostalFacturation():$this->compte->getCodePostal();
            $ville = $this->compte->getVilleFacturation()?$this->compte->getVilleFacturation():$this->compte->getVille();
            $pays = $this->compte->getPaysFacturation()?$this->compte->getPaysFacturation():$this->compte->getPays();
        }

        $builder
            ->add('objet', 'text', array(
        		'required' => true,
            	'label' => 'Objet'
        	))
            ->add('dateValidite', 'date', array('widget' => 'single_text',
    			'input' => 'datetime',
    			'format' => 'dd/MM/yyyy',
    			'attr' => array('class' => 'dateInput'),
    			'required' => true,
    			'label' => 'Date d\'échéance'
        	))
        	->add('dateCreation', 'date', array('widget' => 'single_text',
    			'input' => 'datetime',
    			'format' => 'dd/MM/yyyy',
    			'attr' => array('class' => 'dateInput dateCreationInput'),
    			'required' => true,
    			'label' => 'Date de la facture',
        	))
        	->add('numBCClient', 'text', array(
        		'required' => false,
        		'label' => 'N° bon de commande client'
        	))
           ->add('adresse', 'text', array(
        		'required' => true,
            	'label' => 'Adresse',
             	'attr' => array('class' => 'input-adresse'),
                'data' => $adresse
        	))
           ->add('adresseLigne2', 'text', array(
               'required' => false,
               'label' => 'Adresse (suite)',
               'attr' => array('class' => 'input-adresse-ligne2'),
               'data' => $adresseLigne2
           ))
           ->add('nomFacturation', 'text', array(
               'required' => true,
               'label' => 'Nom de l\'organisation pour la facturation',
               'attr' => array('class' => 'input-nom-facturation'),
               'data' => $nomFacturation
           ))
            ->add('codePostal', 'text', array(
        		'required' => true,
            	'label' => 'Code postal',
            	'attr' => array('class' => 'input-codepostal'),
                'data' => $codePostal
        	))
            ->add('ville', 'text', array(
        		'required' => true,
            	'label' => 'Ville',
            	'attr' => array('class' => 'input-ville'),
                'data' => $ville
        	))
            ->add('region', 'text', array(
        		'required' => true,
            	'label' => 'Région',
            	'attr' => array('class' => 'input-region'),
                'data' => $this->compte ? $this->compte->getRegion() : null
        	))
            ->add('pays', 'text', array(
        		'required' => true,
            	'label' => 'Pays',
            	'attr' => array('class' => 'input-pays'),
                'data' => $pays
        	))
            ->add('description', 'textarea', array(
        		'required' => false,
            	'label' => 'Commentaire'
        	))
            ->add('remise', 'number', array(
        		'required' => false,
            	'label' => 'Remise',
            	'precision' => 2,
            		'attr' => array('class' => 'facture-remise')
        	))
        	->add('cgv', 'textarea', array(
        			'required' => false,
        			'label' => 'Conditions d\'utilisation'
        	))
            ->add('userGestion', 'entity', array(
       			'class'=>'AppBundle:User',
       			'required' => true,
       			'label' => 'Gestionnaire de la facture',
       			'query_builder' => function (EntityRepository $er) {
       				return $er->createQueryBuilder('u')
       				->where('u.company = :company')
       				->andWhere('u.enabled = :enabled')
       				->orWhere('u.id = :id')
       				->orderBy('u.firstname', 'ASC')
       				->setParameter('company', $this->companyId)
       				->setParameter('enabled', 1)
       				->setParameter('id', $this->userGestionId);
       			},
           	))
             ->add('compte_name', 'text', array(
         		'required' => true,
         		'mapped' => false,
         		'label' => 'Organisation',
         		'attr' => array('class' => 'typeahead-compte', 'autocomplete' => 'off')
             ))
             ->add('compte', 'hidden', array(
         		'required' => true,
         		'attr' => array('class' => 'entity-compte')
             ))
		    ->add('contact_name', 'text', array(
	        	'required' => true,
	        	'mapped' => false,
	        	'label' => 'Contact',
	        	'attr' => array('class' => 'typeahead-contact', 'autocomplete' => 'off')
		    ))
		    ->add('contact', 'hidden', array(
	        	'required' => true,
	        	'attr' => array('class' => 'entity-contact')
		    ))
           	->add('devis', 'entity', array(
       			'class'=> 'AppBundle\Entity\CRM\DocumentPrix',
       			'required' => false,
       			'label' => 'N° de devis',
       			'property' => 'num',
       			'query_builder' => function(EntityRepository $er) {
       				return $er->createQueryBuilder('d')
       				->leftJoin('AppBundle\Entity\CRM\Compte', 'c', 'WITH', 'c.id = d.compte')
					->where('c.company = :company')
					->andWhere('d.type = :type')
       				->setParameter('type', 'DEVIS')
       				->setParameter('company', $this->companyId)
       				->orderBy('d.num', 'ASC');
       			},
       			'empty_value' => 'Aucun'
           	))
           	->add('produits', 'collection', array(
       			'type' => new ProduitType($this->companyId),
       			'allow_add' => true,
       			'allow_delete' => true,
       			'by_reference' => false,
       			'label_attr' => array('class' => 'hidden'),
                'options' => array('type' => 'FACTURE')
           	))
           	->add('sousTotal', 'number', array(
       			'required' => false,
       			'label' => 'Sous total',
       			'precision' => 2,
       			'mapped' => false,
       			'read_only' => true,
       			'attr' => array('class' => 'facture-sous-total')
           	))
           	->add('taxe', 'number', array(
       			'required' => false,
       			'precision' => 2,
       			'label_attr' => array('class' => 'hidden'),
       			'attr' => array('class' => 'facture-taxe'),
       			'read_only' => true
           	))
           	->add('taxePercent', 'percent', array(
       			'required' => false,
       			'type' => 'fractional',
       			'precision' => 2,
       			'label' => 'TVA',
       			'attr' => array('class' => 'facture-taxe-percent'),
           	))
			->add('facturationBelge', 'number', array(
				'required' => false,
				'precision' => 2,
				'label_attr' => array('class' => 'hidden'),
				'attr' => array('class' => 'facturation-belgique'),
				'read_only' => true,
				'mapped' => false
			))
			->add('facturationBelgePercent', 'percent', array(
				'required' => false,
				'type' => 'fractional',
				'precision' => 2,
				'label' => 'Facturation Belgique',
				'attr' => array('class' => 'facturation-belgique-percent'),
			))
           	->add('totalHT', 'number', array(
       			'required' => false,
       			'label' => 'Total HT',
       			'precision' => 2,
       			'mapped' => false,
       			'read_only' => true,
       			'attr' => array('class' => 'facture-total-ht')
           	))
           	->add('totalTTC', 'number', array(
       			'required' => false,
       			'label' => 'Total TTC',
       			'precision' => 2,
       			'mapped' => false,
       			'read_only' => true,
       			'attr' => array('class' => 'facture-total-ttc')
           	))
           	->add('analytique', 'entity', array(
       			'class'=> 'AppBundle\Entity\Settings',
       			'required' => true,
       			'label' => 'Analytique',
       			'property' => 'valeur',
       			'query_builder' => function(EntityRepository $er) {
       				return $er->createQueryBuilder('s')
       				->where('s.company = :company')
       				->andWhere('s.module = :module')
       				->andWhere('s.parametre = :parametre')
       				->setParameter('company', $this->companyId)
       				->setParameter('module', 'CRM')
       				->setParameter('parametre', 'ANALYTIQUE');
       			},
                'attr' => array('class' => 'facture-analytique')
           	))
            ->add('bc_name', 'text', array(
                'required' => true,
                'mapped' => false,
                'label' => 'N° bon de commande interne',
                'attr' => array('class' => 'typeahead-bc', 'autocomplete' => 'off')
            ))
            ->add('bc_entity', 'hidden', array(
                'required' => true,
                'attr' => array('class' => 'entity-bc'), 
                'mapped' => false
            ))
            ->add('inclureFrais', 'checkbox', array(
                'label' => ' ',
                'required' => false,
                'mapped' => false,
                'attr' => array(
                    'data-toggle' => 'toggle',
                    'data-on' => 'Oui',
                    'data-off' => 'Non',
                    'data-onstyle' => 'success',
                    'data-offstyle' => 'danger'
                ),
            ))
        ;


      }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\CRM\DocumentPrix'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_crm_facture';
    }

}
