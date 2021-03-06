<?php
namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use AppBundle\Entity\Company;
use AppBundle\Entity\Settings;
use AppBundle\Entity\SettingsActivationOutil;
use AppBundle\Entity\CRM\Compte;
use AppBundle\Entity\CRM\Contact;
use AppBundle\Entity\CRM\Opportunite;
use AppBundle\Entity\CRM\DocumentPrix;
use AppBundle\Entity\CRM\Produit;
use AppBundle\Entity\CRM\BonCommande;

class AppFixtures extends Fixture implements ContainerAwareInterface
{

    protected $container;
    
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        /**********
        * COMPANY 
        **********/

    	//1 company : Nicomak
        $company = new Company();
        $company->setId(1);
        $company->setNom('Nicomak');
        $company->setAdresse('2474 route du lac de Saint André');
        $company->setVille('Les Marches');
        $company->setCodePostal('73800');
        $company->setRegion('Auvergne-Rhône-Alpes');
        $company->setPays('France');
        $company->setTelephone('0479757629');
        $company->setColor('#ec741b');
        $company->setLogo('nicomak.png');
        $company->setTampon('20180205050200-3-signature_et_tampon.jpg');
        $company->setCredits('9999999');
        $company->setSiren('512511577');
        $manager->persist($company);

        /**********
        * SETTINGS ACTIVATION OUTIL
        **********/

        //activation CRM pour Nicomak
        $activationCRM = new SettingsActivationOutil();
        $activationCRM->setCompany($company);
        $activationCRM->setOutil('CRM');
        $activationCRM->setDate(\DateTime::createFromFormat('Y-m-d', '2016-01-01'));
        $manager->persist($activationCRM);

        //activation compta pour Nicomak
        // $activationCRM = new SettingsActivationOutil();
        // $activationCRM->setCompany($company);
        // $activationCRM->setOutil('COMPTA');
        // $activationCRM->setDate(\DateTime::createFromFormat('Y-m-d', '2016-01-01'));
        // $manager->persist($activationCRM);

        /**********
        * SETTINGS 
        **********/

        //1 contact administratif : Myriam Boniface
        $contactAdmin = new Settings();
        $contactAdmin->setParametre('CONTACT_ADMINISTRATIF');
        $contactAdmin->setValeur("Myriam Boniface");
        $contactAdmin->setModule('CRM');
        $contactAdmin->setType('TEXTE');
        $contactAdmin->setCompany($company);
        $contactAdmin->setHelpText('Le nom de votre contact administratif apparaît sur vos devis et factures.');
        $contactAdmin->setTitre('Nom du contact administratif');
        $contactAdmin->setCategorie('GENERAL');
        $manager->persist($contactAdmin);

        //1 RIB
        $rib = new Settings();
        $rib->setParametre('RIB');
        $rib->setValeur("Myriam Code établissement 18106 - Code guichet 00810 - Numéro de compte 96716311870 - Clé RIB 69 -IBAN FR76 1810 6008 1096 7163 1187 069 - Code BIC AGRIFRPP881");
        $rib->setModule('CRM');
        $rib->setType('TEXTE');
        $rib->setCompany($company);
        $rib->setHelpText('Votre RIB apparaît sur vos factures.');
        $rib->setTitre('RIB');
        $rib->setCategorie('GENERAL');
        $manager->persist($rib);

        //2 types de produit : FC, Conseil
        $typeProduitFC = new Settings();
        $typeProduitFC->setParametre('TYPE_PRODUIT');
        $typeProduitFC->setValeur("FC");
        $typeProduitFC->setModule('CRM');
        $typeProduitFC->setType('LISTE');
        $typeProduitFC->setCompany($company);
        $typeProduitFC->setHelpText('Vos différentes catégories de produits');
        $typeProduitFC->setTitre('Type de produit');
        $typeProduitFC->setCategorie('GENERAL');
        $manager->persist($typeProduitFC);
        $this->setReference('type-produit-fc', $typeProduitFC);

        $typeProduitConseil = new Settings();
        $typeProduitConseil->setParametre('TYPE_PRODUIT');
        $typeProduitConseil->setValeur("Conseil");
        $typeProduitConseil->setModule('CRM');
        $typeProduitConseil->setType('LISTE');
        $typeProduitConseil->setCompany($company);
        $typeProduitConseil->setHelpText('Vos différentes catégories de produits');
        $typeProduitConseil->setTitre('Type de produit');
        $typeProduitConseil->setCategorie('GENERAL');
        $manager->persist($typeProduitConseil);
        $this->setReference('type-produit-conseil', $typeProduitConseil);

        //2 réseaux : "BNI RezoBAO" et "Ruche qui dit oui!"
        $reseauBNI = new Settings();
        $reseauBNI->setParametre('RESEAU');
        $reseauBNI->setValeur('BNI RezoBAO');
        $reseauBNI->setModule('CRM');
        $reseauBNI->setType('LISTE');
        $reseauBNI->setCompany($company);
        $reseauBNI->setHelpText('Les réseaux dans lesquels vous rencontrez vos contacts');
        $reseauBNI->setTitre('Réseau');
        $reseauBNI->setCategorie('CONTACT');
        $manager->persist($reseauBNI);

        $reseauRuche = new Settings();
        $reseauRuche->setParametre('RESEAU');
        $reseauRuche->setValeur('Ruche qui dit oui!');
        $reseauRuche->setModule('CRM');
        $reseauRuche->setType('LISTE');
        $reseauRuche->setCompany($company);
        $reseauRuche->setHelpText('Les réseaux dans lesquels vous rencontrez vos contacts');
        $reseauRuche->setTitre('Réseau');
        $reseauRuche->setCategorie('CONTACT');
        $manager->persist($reseauRuche);

        //2 origines : "Appel entrant" et "Web research"
        $origineAppelEntrant = new Settings();
        $origineAppelEntrant->setParametre('ORIGINE');
        $origineAppelEntrant->setValeur('Appel entrant');
        $origineAppelEntrant->setModule('CRM');
        $origineAppelEntrant->setType('LISTE');
        $origineAppelEntrant->setCompany($company);
        $origineAppelEntrant->setHelpText('Comment rencontrez-vous vos contacts ?');
        $origineAppelEntrant->setTitre('Origine');
        $origineAppelEntrant->setCategorie('CONTACT');
        $manager->persist($origineAppelEntrant);
        $this->setReference('origine-appel-entrant', $origineAppelEntrant);

        $origineWebResearch = new Settings();
        $origineWebResearch->setParametre('ORIGINE');
        $origineWebResearch->setValeur('Web research');
        $origineWebResearch->setModule('CRM');
        $origineWebResearch->setType('LISTE');
        $origineWebResearch->setCompany($company);
        $origineWebResearch->setHelpText('Comment rencontrez-vous vos contacts ?');
        $origineWebResearch->setTitre('Origine');
        $origineWebResearch->setCategorie('CONTACT');
        $manager->persist($origineWebResearch);
        $this->setReference('origine-web-research', $origineWebResearch);

        //2 thèmes d'intérêt : RSE et Diversité
        $themeRSE = new Settings();
        $themeRSE->setParametre('THEME_INTERET');
        $themeRSE->setValeur('RSE');
        $themeRSE->setModule('CRM');
        $themeRSE->setType('LISTE');
        $themeRSE->setCompany($company);
        $themeRSE->setHelpText('Les thèmes sur lesquels vous travaillez pouvant intéresser vos contacts');
        $themeRSE->setTitre('Thèmes d\'intérêt');
        $themeRSE->setCategorie('CONTACT');
        $manager->persist($themeRSE);

        $themeDiversite = new Settings();
        $themeDiversite->setParametre('THEME_INTERET');
        $themeDiversite->setValeur('Diversité');
        $themeDiversite->setModule('CRM');
        $themeDiversite->setType('LISTE');
        $themeDiversite->setCompany($company);
        $themeDiversite->setHelpText('Les thèmes sur lesquels vous travaillez pouvant intéresser vos contacts');
        $themeDiversite->setTitre('Thèmes d\'intérêt');
        $themeDiversite->setCategorie('CONTACT');
        $manager->persist($themeDiversite);

        //2 services d'intérêt : "Conseil" et "Formation inter"
        $serviceConseil = new Settings();
        $serviceConseil->setParametre('SERVICE_INTERET');
        $serviceConseil->setValeur('Conseil');
        $serviceConseil->setModule('CRM');
        $serviceConseil->setType('LISTE');
        $serviceConseil->setCompany($company);
        $serviceConseil->setHelpText('Les services que vous proposez pouvant intéresser vos contacts');
        $serviceConseil->setTitre('Services d\'intérêt');
        $serviceConseil->setCategorie('CONTACT');
        $manager->persist($serviceConseil);

        $serviceInter = new Settings();
        $serviceInter->setParametre('SERVICE_INTERET');
        $serviceInter->setValeur('Formation inter');
        $serviceInter->setModule('CRM');
        $serviceInter->setType('LISTE');
        $serviceInter->setCompany($company);
        $serviceInter->setHelpText('Les services que vous proposez pouvant intéresser vos contacts');
        $serviceInter->setTitre('Services d\'intérêt');
        $serviceInter->setCategorie('CONTACT');
        $manager->persist($serviceInter);

        //2 types de contact : "Client" et "Prospect"
        $typeClient = new Settings();
        $typeClient->setParametre('TYPE');
        $typeClient->setValeur('Client');
        $typeClient->setModule('CRM');
        $typeClient->setType('LISTE');
        $typeClient->setCompany($company);
        $typeClient->setHelpText('Classez vos contacts par type (prospect, client, fournisseur, etc)');
        $typeClient->setTitre('Type de contact');
        $typeClient->setCategorie('CONTACT');
        $manager->persist($typeClient);
        $this->setReference('type-contact-client', $typeClient);

        $typeProspect = new Settings();
        $typeProspect->setParametre('TYPE');
        $typeProspect->setValeur('Prospect');
        $typeProspect->setModule('CRM');
        $typeProspect->setType('LISTE');
        $typeProspect->setCompany($company);
        $typeProspect->setHelpText('Classez vos contacts par type (prospect, client, fournisseur, etc)');
        $typeProspect->setTitre('Type de contact');
        $typeProspect->setCategorie('CONTACT');
        $manager->persist($typeProspect);
        $this->setReference('type-contact-prospect', $typeProspect);

         //2 secteurs d'activité : "Agriculture & Pêche" et "Chimie, Pharmacie, Cosmétique & Santé"
        $secteurAgriculture = new Settings();
        $secteurAgriculture->setParametre('SECTEUR');
        $secteurAgriculture->setValeur("Agriculture & Pêche");
        $secteurAgriculture->setModule('CRM');
        $secteurAgriculture->setType('LISTE');
        $secteurAgriculture->setCompany($company);
        $secteurAgriculture->setHelpText('Quels sont les secteurs d\'activité de vos contacts?');
        $secteurAgriculture->setTitre('Secteur d\'activité');
        $secteurAgriculture->setCategorie('CONTACT');
        $manager->persist($secteurAgriculture);
        $this->setReference('secteur-agriculture', $secteurAgriculture);

        $secteurChimie = new Settings();
        $secteurChimie->setParametre('SECTEUR');
        $secteurChimie->setValeur("Chimie, Pharmacie, Cosmétique & Santé");
        $secteurChimie->setModule('CRM');
        $secteurChimie->setType('LISTE');
        $secteurChimie->setCompany($company);
        $secteurChimie->setHelpText('Quels sont les secteurs d\'activité de vos contacts?');
        $secteurChimie->setTitre('Secteur d\'activité');
        $secteurChimie->setCategorie('CONTACT');
        $manager->persist($secteurChimie);
        $this->setReference('secteur-chimie', $secteurChimie);

        //1 type condition générales de vente devis
        $cgvDevis = new Settings();
        $cgvDevis->setParametre('CGV_DEVIS');
        $cgvDevis->setValeur("La signature du devis équivaut à l'acceptation de nos conditions générales de vente, disponibles sur notre site web : http://www.nicomak.eu/conditions-generales-de-vente");
        $cgvDevis->setModule('CRM');
        $cgvDevis->setType('TEXTE');
        $cgvDevis->setCompany($company);
        $cgvDevis->setHelpText('Vos conditions générales de vente apparaîssent sur votre devis.');
        $cgvDevis->setTitre('Conditions générales de vente (devis)');
        $cgvDevis->setCategorie('DEVIS');
        $manager->persist($cgvDevis);

        //1 numéro devis : 1
        $numDevis = new Settings();
        $numDevis->setParametre('NUMERO_DEVIS');
        $numDevis->setValeur("2");
        $numDevis->setModule('CRM');
        $numDevis->setType('NUM');
        $numDevis->setCompany($company);
        $numDevis->setHelpText('Le numéro de devis courant - ne pas modifier si vous n\'êtes pas sûr de ce que vous faites !');
        $numDevis->setTitre('Numéro de devis');
        $numDevis->setCategorie('DEVIS');
        $manager->persist($numDevis);

        //1 pied de page devis
        $piedPageDevis = new Settings();
        $piedPageDevis->setParametre('PIED_DE_PAGE_DEVIS');
        $piedPageDevis->setValeur("SARL au capital de 9 000€ - RCS Chambéry B 512 511 577 - Siret 512 511 577 00011 - Numéro TVA FR 62 512 511 577<br /> NAF 8559 A - Numéro formateur 82 73 01371 73");
        $piedPageDevis->setModule('CRM');
        $piedPageDevis->setType('TEXTE');
        $piedPageDevis->setCompany($company);
        $piedPageDevis->setHelpText('Le texte à utiliser comme pied de page sur vos devis.');
        $piedPageDevis->setTitre('Pied de page (devis)');
        $piedPageDevis->setCategorie('DEVIS');
        $manager->persist($piedPageDevis);

        //1 numéro facture : 1
        $numFacture = new Settings();
        $numFacture->setParametre('NUMERO_FACTURE');
        $numFacture->setValeur("2");
        $numFacture->setModule('CRM');
        $numFacture->setType('NUM');
        $numFacture->setCompany($company);
        $numFacture->setHelpText('Le numéro de facture courant - ne pas modifier si vous n\'êtes pas sûr de ce que vous faites !');
        $numFacture->setTitre('Numéro de facture');
        $numFacture->setCategorie('FACTURE');
        $manager->persist($numFacture);

        //1 type condition générales de vente facture
        $cgvFacture = new Settings();
        $cgvFacture->setParametre('CGV_FACTURE');
        $cgvFacture->setValeur("En cas de retard de paiement application d’une indemnité forfaitaire pour frais de recouvrement de 40€ selon l'article D. 441-5 du code du commerce, et application d'intérêts de 3 fois le taux légal selon la loi n°2008-776.<br />Nos conditions générales de vente sont disponibles sur notre site web http://www.nicomak.eu/conditions-generales-de-vente. Organisme de formation enregistré auprès de la DIRECCTE Auvergne Rhône-Alpes, Nicomak est exonéré de TVA sur ses actions de formation continue en fonction de l’article 261.4.4° a du CGI");
        $cgvFacture->setModule('CRM');
        $cgvFacture->setType('TEXTE');
        $cgvFacture->setCompany($company);
        $cgvFacture->setHelpText('Vos conditions générales de vente apparaîssent sur votre facture.');
        $cgvFacture->setTitre('Conditions générales de vente (facture)');
        $cgvFacture->setCategorie('FACTURE');
        $manager->persist($cgvFacture);

        //1 pied de page facture
        $piedPageFacture = new Settings();
        $piedPageFacture->setParametre('PIED_DE_PAGE_FACTURE');
        $piedPageFacture->setValeur("SARL au capital de 9 000€ - RCS Chambéry B 512 511 577 - Siret 512 511 577 00011 - Numéro TVA FR 62 512 511 577<br />NAF 8559 A - Numéro formateur 82 73 01371 73");
        $piedPageFacture->setModule('CRM');
        $piedPageFacture->setType('TEXTE');
        $piedPageFacture->setCompany($company);
        $piedPageFacture->setHelpText('Le texte à utiliser comme pied de page sur vos factures.');
        $piedPageFacture->setTitre('Pied de page (devis)');
        $piedPageFacture->setCategorie('FACTURE');
        $manager->persist($piedPageFacture);

        //1 image de pub facture
        $pubFactureImage = new Settings();
        $pubFactureImage->setParametre('PUB_FACTURE_IMAGE');
        $pubFactureImage->setValeur("20170428050436-3-visuel-logo-divertik.png");
        $pubFactureImage->setModule('CRM');
        $pubFactureImage->setType('IMAGE');
        $pubFactureImage->setCompany($company);
        $pubFactureImage->setHelpText('Utilisez vos factures comme support publicitaire en insérant une image.');
        $pubFactureImage->setTitre('Image de pub pour les factures');
        $pubFactureImage->setCategorie('FACTURE');
        $manager->persist($pubFactureImage);

        //1 texte de pub facture
        $pubFactureTexte = new Settings();
        $pubFactureTexte->setParametre('PUB_FACTURE_TEXTE');
        $pubFactureTexte->setValeur("80% des entreprises ont indiqué que la diversité était un axe stratégique pour leur développement. Et vous, comment vous occupez-vous de ce thème ? Nicomak peut vous aider de manière concrète avec son Outil Divertik. Contactez Myriam pour qu'elle vous en dise plus !");
        $pubFactureTexte->setModule('CRM');
        $pubFactureTexte->setType('TEXTE');
        $pubFactureTexte->setCompany($company);
        $pubFactureTexte->setHelpText('Utilisez vos factures comme support publicitaire en insérant un court texte.');
        $pubFactureTexte->setTitre('Texte de pub sur les factures');
        $pubFactureTexte->setCategorie('FACTURE');
        $manager->persist($pubFactureTexte);

        //2 analytiques : FC et Conseil
        $analytiqueFC = new Settings();
        $analytiqueFC->setParametre('ANALYTIQUE');
        $analytiqueFC->setValeur("FC");
        $analytiqueFC->setModule('CRM');
        $analytiqueFC->setType('LISTE');
        $analytiqueFC->setCompany($company);
        $analytiqueFC->setHelpText('Vos catégories pour réaliser des classements analytiques de vos ventes');
        $analytiqueFC->setTitre('Analytique');
        $analytiqueFC->setCategorie('FACTURE');
        $manager->persist($analytiqueFC);
        $this->setReference('analytique-fc', $analytiqueFC);

        $analytiqueConseil = new Settings();
        $analytiqueConseil->setParametre('ANALYTIQUE');
        $analytiqueConseil->setValeur("Conseil");
        $analytiqueConseil->setModule('CRM');
        $analytiqueConseil->setType('LISTE');
        $analytiqueConseil->setCompany($company);
        $analytiqueConseil->setHelpText('Vos catégories pour réaliser des classements analytiques de vos ventes');
        $analytiqueConseil->setTitre('Analytique');
        $analytiqueConseil->setCategorie('FACTURE');
        $manager->persist($analytiqueConseil);
        $this->setReference('analytique-conseil', $analytiqueConseil);

        //1 probabilité action commerciale
        $probabiliteActionCo = new Settings();
        $probabiliteActionCo->setParametre('OPPORTUNITE_STATUT');
        $probabiliteActionCo->setValeur("FD - 50%");
        $probabiliteActionCo->setModule('CRM');
        $probabiliteActionCo->setType('LISTE');
        $probabiliteActionCo->setCompany($company);
        $probabiliteActionCo->setHelpText('Les différents statuts que peuvent avoir vos opportunités');
        $probabiliteActionCo->setTitre('Statut des opportunités');
        $probabiliteActionCo->setCategorie('OPPORTUNITE');
        $manager->persist($probabiliteActionCo);
        $this->setReference('probabilite-action-co', $probabiliteActionCo);



        /**********
        * USER
        **********/
        $userManager = $this->container->get('fos_user.user_manager');

        //2 users : Laura et Myriam
        $userLaura = $userManager->createUser();
        $userLaura->setId(1);
        $userLaura->setCompany($company);
        $userLaura->setFirstName("Laura");
        $userLaura->setLastName("Gilquin");
        $userLaura->setEmail("gilquin@nicomak.eu");
        $userLaura->setUsername("laura");
        $userLaura->setPlainPassword("laura");
        $userLaura->setEnabled(true);
        $userLaura->setRoles(array(
            'ROLE_ADMIN', 
            'ROLE_SUPER_ADMIN', 
            'ROLE_COMMERCIAL', 
            'ROLE_COMPTA', 
            'ROLE_COMMUNICATION', 
            'ROLE_RH', 
            'ROLE_NDF'
        ));
        $userLaura->setSignature('20170719040746-3-signature.bmp');
        $userLaura->setAvatar('s.png');
        $userLaura->setCompetCom(true);
        $manager->persist($userLaura);
        $this->setReference('user-laura', $userLaura);

        $userMyriam = $userManager->createUser();
        $userMyriam->setId(2);
        $userMyriam->setCompany($company);
        $userMyriam->setFirstName("Myriam");
        $userMyriam->setLastName("Boniface");
        $userMyriam->setEmail("boniface@nicomak.eu");
        $userMyriam->setUsername("myriam");
        $userMyriam->setPlainPassword("myriam");
        $userMyriam->setEnabled(true);
        $userMyriam->setRoles(array(
            'ROLE_ADMIN',
            'ROLE_COMMERCIAL', 
            'ROLE_COMPTA', 
            'ROLE_COMMUNICATION', 
            'ROLE_RH', 
            'ROLE_NDF'
        ));
        $userMyriam->setSignature('20170905030952-1-Signature.Myriam.jpg');
        $userMyriam->setAvatar('s.png');
        $userMyriam->setCompetCom(true);
        $manager->persist($userMyriam);

        /**********
        * COMPTE
        **********/

        //deux comptes : Nicomak et DemoCorp
        $compteNicomak = new Compte();
        $compteNicomak->setId(1);
        $compteNicomak->setCompany($company);
        $compteNicomak->setNom('Nicomak');
        $compteNicomak->setAdresse('2474 route du lac de Saint André');
        $compteNicomak->setCodePostal('73800');
        $compteNicomak->setVille('Les Marches');
        $compteNicomak->setRegion('Auvergne-Rhône-Alpes');
        $compteNicomak->setPays('France');
        $compteNicomak->setTelephone('0479757629');
        $compteNicomak->setDateCreation(\DateTime::createFromFormat('Y-m-d', '2016-01-01'));
        $compteNicomak->setUserCreation($userMyriam);
        $compteNicomak->setUserGestion($userMyriam);
        $compteNicomak->setDescription("Super boîte");
        $compteNicomak->setUrl("hhtp://www.nicomak.eu");
        $compteNicomak->setSecteurActivite($secteurAgriculture);
        $metadata = $manager->getClassMetadata(get_class($compteNicomak));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $manager->persist($compteNicomak);

        $compteDemoCorp = new Compte();
        $compteDemoCorp->setId(2);
        $compteDemoCorp->setCompany($company);
        $compteDemoCorp->setNom('DemoCorp');
        $compteDemoCorp->setAdresse('110 allée promenade des bords du lac');
        $compteDemoCorp->setCodePostal('73100');
        $compteDemoCorp->setVille('Aix les Bains');
        $compteDemoCorp->setRegion('Auvergne-Rhône-Alpes');
        $compteDemoCorp->setPays('France');
        $compteDemoCorp->setTelephone('0404040404');
        $compteDemoCorp->setDateCreation(\DateTime::createFromFormat('Y-m-d', '2018-01-01'));
        $compteDemoCorp->setUserCreation($userLaura);
        $compteDemoCorp->setUserEdition($userMyriam);
        $compteDemoCorp->setDateCreation(\DateTime::createFromFormat('Y-m-d', '2018-02-01'));
        $compteDemoCorp->setUserGestion($userMyriam);
        $compteDemoCorp->setDescription("Organisation demo");
        $compteDemoCorp->setUrl("hhtp://www.democorp.com");
        $compteDemoCorp->setSecteurActivite($secteurChimie);
        $metadata = $manager->getClassMetadata(get_class($compteDemoCorp));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $manager->persist($compteDemoCorp);

        /**********
        * CONTACT
        **********/

        //2 contacts à Nicomak : Céline Gindre et Geoffroy Murat
        $contactGeoffroy = new Contact();
        $contactGeoffroy->setCompte($compteNicomak);
        $contactGeoffroy->setId(1);
        $contactGeoffroy->setPrenom('Geoffroy');
        $contactGeoffroy->setNom('Murat');
        $contactGeoffroy->setTitre('Directeur');
        $contactGeoffroy->setAdresse($compteNicomak->getAdresse());
        $contactGeoffroy->setCodePostal($compteNicomak->getCodePostal());
        $contactGeoffroy->setVille($compteNicomak->getVille());
        $contactGeoffroy->setRegion($compteNicomak->getRegion());
        $contactGeoffroy->setPays($compteNicomak->getPays());
        $contactGeoffroy->setTelephoneFixe('0479757629');
        $contactGeoffroy->setTelephonePortable('0675766684');
        $contactGeoffroy->setEmail('murat@nicomak.eu');
        $contactGeoffroy->setEmail2('murat.nicomak@gmail.com');
        $contactGeoffroy->setNewsletter(true);
        $contactGeoffroy->setCarteVoeux(false);
        $contactGeoffroy->setDateCreation(\DateTime::createFromFormat('Y-m-d', '2016-02-01'));
        $contactGeoffroy->setUserCreation($userMyriam);
        $contactGeoffroy->setUserGestion($userMyriam);
        $metadata = $manager->getClassMetadata(get_class($contactGeoffroy));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $manager->persist($contactGeoffroy);

        $contactCeline = new Contact();
        $contactCeline->setCompte($compteNicomak);
        $contactCeline->setId(2);
        $contactCeline->setPrenom('Céline');
        $contactCeline->setNom('Gindre');
        $contactCeline->setTitre('Consultante');
        $contactCeline->setAdresse($compteNicomak->getAdresse());
        $contactCeline->setCodePostal($compteNicomak->getCodePostal());
        $contactCeline->setVille($compteNicomak->getVille());
        $contactCeline->setRegion($compteNicomak->getRegion());
        $contactCeline->setPays($compteNicomak->getPays());
        $contactCeline->setTelephoneFixe('0479757629');
        $contactCeline->setTelephonePortable('0652333727');
        $contactCeline->setEmail('gindre@nicomak.eu');
        $contactCeline->setNewsletter(true);
        $contactCeline->setCarteVoeux(false);
        $contactCeline->setDateCreation(\DateTime::createFromFormat('Y-m-d', '2016-03-01'));
        $contactCeline->setUserCreation($userMyriam);
        $contactCeline->setUserGestion($userMyriam);
        $metadata = $manager->getClassMetadata(get_class($contactCeline));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $manager->persist($contactCeline);

        //1 contact à DemoCorp : Potiron Groschat
        $contactPotiron = new Contact();
        $contactPotiron->setCompte($compteDemoCorp);
        $contactPotiron->setId(3);
        $contactPotiron->setPrenom('Potiron');
        $contactPotiron->setNom('Groschat');
        $contactPotiron->setTitre('PDG');
        $contactPotiron->setAdresse($compteDemoCorp->getAdresse());
        $contactPotiron->setCodePostal($compteDemoCorp->getCodePostal());
        $contactPotiron->setVille($compteDemoCorp->getVille());
        $contactPotiron->setRegion($compteDemoCorp->getRegion());
        $contactPotiron->setPays($compteDemoCorp->getPays());
        $contactPotiron->setTelephonePortable('0686747075');
        $contactPotiron->setEmail('potiron@democorp.com');
        $contactPotiron->setNewsletter(true);
        $contactPotiron->setCarteVoeux(true);
        $contactPotiron->setOrigine($origineWebResearch);
        $contactPotiron->setReseau($reseauBNI);
        $contactPotiron->addSetting($themeDiversite);
        $contactPotiron->addSetting($serviceInter);
        $contactPotiron->addSetting($serviceConseil);
        $contactPotiron->addSetting($typeProspect);
        $contactPotiron->setDateCreation(\DateTime::createFromFormat('Y-m-d', '2018-01-01'));
        $contactPotiron->setUserCreation($userLaura);
        $contactPotiron->setUserGestion($userLaura);
        $metadata = $manager->getClassMetadata(get_class($contactPotiron));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        $manager->persist($contactPotiron);

        /**********
        * ACTION COMMERCIALE (ET DEVIS) + BON DE COMMANDE
        **********/

         //1 action commerciale à DemoCorp - Potiron Groschat
        $actionCommerciale = new Opportunite();
        $actionCommerciale->setId(1);
        $actionCommerciale->setCompte($compteDemoCorp);
        $actionCommerciale->setContact($contactPotiron);
        $actionCommerciale->setNom('Conseil diversité');
        $actionCommerciale->setMontant(1000);
        $actionCommerciale->setDate(\DateTime::createFromFormat('Y-m-d', '2018-02-01'));
        $actionCommerciale->setType('Existing Business');
        $actionCommerciale->setProbabilite($probabiliteActionCo);
        $actionCommerciale->setPriveOrPublic('PRIVE');
        $actionCommerciale->setAnalytique($analytiqueConseil);
        $actionCommerciale->setOrigine($origineAppelEntrant);
        $actionCommerciale->setDateCreation(\DateTime::createFromFormat('Y-m-d', '2018-01-01'));
        $actionCommerciale->setUserCreation($userLaura);
        $actionCommerciale->setUserGestion($userLaura);
        $metadata = $manager->getClassMetadata(get_class($actionCommerciale));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
        
        $devis = new DocumentPrix($company,'DEVIS');
        $devis->setId(1);
        $devis->setCompte($actionCommerciale->getCompte());
        $devis->setContact($actionCommerciale->getContact());
        $devis->setDateCreation($actionCommerciale->getDateCreation());
        $devis->setUserCreation($actionCommerciale->getuserCreation());
        $devis->setObjet($actionCommerciale->getNom());
        $devis->setUserGestion($actionCommerciale->getUserGestion());
        $devis->setAnalytique($actionCommerciale->getAnalytique());
        $devis->setAdresse($compteDemoCorp->getAdresse());
        $devis->setCodePostal($compteDemoCorp->getCodePostal());
        $devis->setVille($compteDemoCorp->getVille());
        $devis->setRegion($compteDemoCorp->getRegion());
        $devis->setPays($compteDemoCorp->getPays());
        $devis->setDateValidite(\DateTime::createFromFormat('Y-m-d', '2018-03-01'));
        $devis->setCGV($cgvDevis);
        $devis->setTaxe(200);
        $devis->setTaxePercent(0.2);
        $devis->setNum('2018-001');
        $metadata = $manager->getClassMetadata(get_class($devis));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $produit = new Produit();
        $produit->setType($typeProduitConseil);
        $produit->setNom('Journée de conseil');
        $produit->setDescription('Journée de conseil dans vos locaux');
        $produit->setTarifUnitaire(1000);
        $produit->setQuantite(1);
        $produit->setRemise(0);

        $devis->addProduit($produit);
        $this->setReference('devis-2018-001', $devis);
        $manager->persist($devis);

        $actionCommerciale->setDevis($devis);

        $bonCommande = new BonCommande();
        $bonCommande->setNum('2018-001');
        $bonCommande->setMontant(10000);
        $actionCommerciale->addBonsCommande($bonCommande);
        $this->setReference('bon-commande-2018-001', $bonCommande);
        $manager->persist($bonCommande);

        $manager->persist($actionCommerciale);


        /**********
        *FACTURE
        **********/
        $facture = new DocumentPrix($company, 'FACTURE');
        $facture->setId(2);
        $facture->setCompte($compteDemoCorp);
        $facture->setContact($contactPotiron);
        $facture->setDateCreation(\DateTime::createFromFormat('Y-m-d', '2018-03-01'));
        $facture->setUserCreation($devis->getuserCreation());
        $facture->setObjet('Formation');
        $facture->setUserGestion($userMyriam);
        $facture->setAnalytique($analytiqueFC);
        $facture->setAdresse($compteDemoCorp->getAdresse());
        $facture->setCodePostal($compteDemoCorp->getCodePostal());
        $facture->setVille($compteDemoCorp->getVille());
        $facture->setRegion($compteDemoCorp->getRegion());
        $facture->setPays($compteDemoCorp->getPays());
        $facture->setDateValidite(\DateTime::createFromFormat('Y-m-d', '2018-04-01'));
        $facture->setCGV($cgvFacture);
        $facture->setNum('2018-001');
        $facture->setBonCommande($bonCommande);
        $metadata = $manager->getClassMetadata(get_class($facture));
        $metadata->setIdGenerator(new \Doctrine\ORM\Id\AssignedGenerator());
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);

        $produit = new Produit();
        $produit->setType($typeProduitConseil);
        $produit->setNom('Journée de formation');
        $produit->setDescription('Journée de formation dans vos locaux');
        $produit->setTarifUnitaire(1000);
        $produit->setQuantite(1);
        $produit->setRemise(0);

        $facture->addProduit($produit);
        $manager->persist($facture);

        $manager->flush();
    }
}