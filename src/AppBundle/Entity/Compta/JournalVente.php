<?php

namespace AppBundle\Entity\Compta;

use Doctrine\ORM\Mapping as ORM;

/**
 * JournalVente
 *
 * @ORM\Table("journal_vente")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Compta\JournalVenteRepository")
 */
class JournalVente
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="codeJournal", type="string", length=255)
     */
    private $codeJournal;

    /**
     * @var string
     *
     * @ORM\Column(name="debit", type="float", nullable=true)
     */
    private $debit;

    /**
     * @var string
     *
     * @ORM\Column(name="credit", type="float", nullable=true)
     */
    private $credit;

    /**
     * @var string
     *
     * @ORM\Column(name="modePaiement", type="string", length=255, nullable=true)
     */
    private $modePaiement;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CRM\DocumentPrix", cascade={ "persist"}, inversedBy="journalVentes")
     * @ORM\JoinColumn(nullable=true, unique=false)
     */
    private $facture;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Compta\Avoir", cascade={"persist"}, inversedBy="journalVentes")
     * @ORM\JoinColumn(nullable=true, unique=false)
     */
    private $avoir;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Compta\CompteComptable", inversedBy="journalVentes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compteComptable;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Settings")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $analytique;

    /**
     * @var string
     *
     * @ORM\Column(name="lettrage", type="string", length=100, nullable=true)
     */
    private $lettrage;

     /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255, nullable=true)
     */
    private $libelle;

    /**
     * @var string
     *
     * @ORM\Column(name="num_ecriture", type="string", length=50, nullable=true)
     */
    private $numEcriture;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set codeJournal
     *
     * @param string $codeJournal
     * @return JournalVente
     */
    public function setCodeJournal($codeJournal)
    {
        $this->codeJournal = $codeJournal;

        return $this;
    }

    /**
     * Get codeJournal
     *
     * @return string
     */
    public function getCodeJournal()
    {
        return $this->codeJournal;
    }

    /**
     * Set debit
     *
     * @param string $debit
     * @return JournalVente
     */
    public function setDebit($debit)
    {
        $this->debit = $debit;

        return $this;
    }

    /**
     * Get debit
     *
     * @return string
     */
    public function getDebit()
    {
        return $this->debit;
    }

    /**
     * Set credit
     *
     * @param string $credit
     * @return JournalVente
     */
    public function setCredit($credit)
    {
        $this->credit = $credit;

        return $this;
    }

    /**
     * Get credit
     *
     * @return string
     */
    public function getCredit()
    {
        return $this->credit;
    }

    /**
     * Set modePaiement
     *
     * @param string $modePaiement
     * @return JournalVente
     */
    public function setModePaiement($modePaiement)
    {
        $this->modePaiement = $modePaiement;

        return $this;
    }

    /**
     * Get modePaiement
     *
     * @return string
     */
    public function getModePaiement()
    {
        return $this->modePaiement;
    }
	public function getFacture() {
		return $this->facture;
	}
	public function setFacture($facture) {
		$this->facture = $facture;
		return $this;
	}
	public function getCompteComptable() {
		return $this->compteComptable;
	}
	public function setCompteComptable($compteComptable) {
		$this->compteComptable = $compteComptable;
		return $this;
	}
	public function getAnalytique() {
		return $this->analytique;
	}
	public function setAnalytique($analytique) {
		$this->analytique = $analytique;
		return $this;
	}



    /**
     * Set avoir
     *
     * @param \AppBundle\Entity\Compta\Avoir $avoir
     * @return JournalVente
     */
    public function setAvoir(\AppBundle\Entity\Compta\Avoir $avoir = null)
    {
        $this->avoir = $avoir;

        return $this;
    }

    /**
     * Get avoir
     *
     * @return \AppBundle\Entity\Compta\Avoir
     */
    public function getAvoir()
    {
        return $this->avoir;
    }

    public function getDate(){
      if($this->facture){
        return $this->facture->getDateCreation();
      } else if($this->avoir) {
        return $this->avoir->getDateCreation();
      }
      return null;
    }

    public function getDateCreation(){
      if($this->facture){
        return $this->facture->getDateCreation();
      } else if($this->avoir) {
        return $this->avoir->getDateCreation();
      }
      return null;
    }

    public function getLibelle(){
      if($this->facture){
        return $this->facture->getNum().' : '.$this->facture->getObjet();
      } else if($this->avoir) {
        return $this->avoir->getNum().' : '.$this->avoir->getObjet();
      }
      return null;
    }

    public function getPiece(){
      if($this->facture){
        return $this->facture->getNum();
      } else if($this->avoir) {
        return $this->avoir->getNum();
      }
      return null;
    }

    public function getPieceId(){
      if($this->facture){
        return $this->facture->getId();
      } else if($this->avoir) {
        return $this->avoir->getId();
      }
      return null;
    }

    public function getDatePiece(){
      if($this->facture){
        return $this->facture->getDateCreation();
      } else if($this->avoir) {
        return $this->avoir->getDateCreation();
      }
      return null;
    }

    /**
     * Set lettrage
     *
     * @param string $lettrage
     * @return JournalVente
     */
    public function setLettrage($lettrage)
    {
        $this->lettrage = $lettrage;

        return $this;
    }

    /**
     * Get lettrage
     *
     * @return string 
     */
    public function getLettrage()
    {
        return $this->lettrage;
    }

    /**
     * Set libelle
     *
     * @param string $libelle
     * @return JournalVente
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Set numEcriture
     *
     * @param string $numEcriture
     * @return JournalVente
     */
    public function setNumEcriture($numEcriture)
    {
        $this->numEcriture = $numEcriture;

        return $this;
    }

    /**
     * Get numEcriture
     *
     * @return string 
     */
    public function getNumEcriture()
    {
        return $this->numEcriture;
    }

    /**
     * Set commentaire
     *
     * @param string $commentaire
     * @return JournalVente
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string 
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }
}
