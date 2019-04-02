<?php

namespace AppBundle\Service\CRM;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\CRM\DocumentPrix;
use AppBundle\Entity\CRM\Produit;

class FactureService extends ContainerAware {

    protected $em;

    public function __construct(\Doctrine\ORM\EntityManager $em)
    {
        $this->em = $em;
    }

    public function getDataChartCAAnalytique($company, $year){

        $settingsRepo = $this->em->getRepository('AppBundle:Settings');
        $arr_analytiques = $settingsRepo->findBy(array(
          'company' => $company,
          'parametre' => 'analytique',
          'module' => 'CRM'
        ));

        $factureRepo = $this->em->getRepository('AppBundle:CRM\DocumentPrix');
        $arr_factures = $factureRepo->findForCompanyByYear($company, 'FACTURE', $year);

        $arr_total = array();
        foreach($arr_analytiques as $analytique){
            $arr_total[$analytique->getValeur()] = array(
                'public' => 0,
                'prive' => 0
            );
        }
        
        foreach($arr_factures as $facture){
           
            if($facture->isSecteurPublic()){
                $arr_total[$facture->getAnalytique()->getValeur()]['public']+= $facture->getMontant();
            } else {
                $arr_total[$facture->getAnalytique()->getValeur()]['prive']+= $facture->getMontant();
            }
        }
        return $arr_total;
    }

    public function createProduitFromPlanPaiement($planPaiement){

        $produit = new Produit();
        $produit->setNom($planPaiement->getNom());

        $description = $planPaiement->getPourcentage().'% ';
        if($planPaiement->getCommande()){
            $description.='à la commande';
        } else if ($planPaiement->getFinProjet()){
            $description.='à la fin du projet';
        } else {
            $description.='au '.$planPaiement->getDate()->format('d/m/Y');
        }
        $description.=' d\'après devis';
        $produit->setDescription($description);

        $actionCommerciale = $planPaiement->getActionCommerciale();
        $produit->setTarifUnitaire($actionCommerciale->getMontant());
        $produit->setQuantite($planPaiement->getPourcentageNumerique());
        $produit->setType($actionCommerciale->getAnalytique());

        return $produit;

    }

    public function createProduitsFrais($facture, $lignes){

        foreach($facture->getProduits() as $produit){
            $this->em->remove($produit);
        }
        $facture->clearProduits();

        $produitRepo = $this->em->getRepository('AppBundle:CRM\Produit');
        foreach($lignes as $ligneId){
            $ligne = $produitRepo->find($ligneId);
            $produit = clone($ligne);
            $facture->addProduit($produit);
        }

        return $facture;

    }

    // public function getDataChartActionsCoRhoneAlpes($company, $year){

    //     $opportuniteRepo = $this->em->getRepository('AppBundle:CRM\Opportunite');
    //     $arr_opportunite = $opportuniteRepo->findForCompanyByYear($company, $year);

    //     $arr_total = array();
       
    //     $arr_total['Rhône-Alpes'] = array(
    //         'public' => 0,
    //         'prive' => 0
    //     );
    //     $arr_total['Hors Rhône-Alpes'] = array(
    //         'public' => 0,
    //         'prive' => 0
    //     );

        
    //     foreach($arr_opportunite as $opportunite){
           
    //         if( (substr($opportunite->getCompte()->getCodePostal(),0,2) === '73') ||
    //             (substr($opportunite->getCompte()->getCodePostal(),0,2) === '38') ||
    //             (substr($opportunite->getCompte()->getCodePostal(),0,2) === '74') ||
    //             (substr($opportunite->getCompte()->getCodePostal(),0,2) === '69') ||
    //             (substr($opportunite->getCompte()->getCodePostal(),0,2) === '01') ||
    //             (substr($opportunite->getCompte()->getCodePostal(),0,2) === '26') ||
    //             (substr($opportunite->getCompte()->getCodePostal(),0,2) === '07')
    //         ){
    //             if($opportunite->isSecteurPublic()){
    //                 $arr_total['Rhône-Alpes']['public']+= $opportunite->getMontant();
    //             } else {
    //                 $arr_total['Rhône-Alpes']['prive']+= $opportunite->getMontant();
    //             }
    //         } else {
    //             if($opportunite->isSecteurPublic()){
    //                 $arr_total['Hors Rhône-Alpes']['public']+= $opportunite->getMontant();
    //             } else {
    //                 $arr_total['Hors Rhône-Alpes']['prive']+= $opportunite->getMontant();
    //             }
    //         }
    //     }
    //     return $arr_total;
    // }

}
