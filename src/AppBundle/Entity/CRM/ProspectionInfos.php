<?php

namespace AppBundle\Entity\CRM;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * ProspectionInfos
 *
 * @ORM\Table(name="prospectionInfos", uniqueConstraints={@UniqueConstraint(name="prospectionInfos", columns={"contact", "prospection"})})
 * @ORM\Entity(repositoryClass="AppBundle\Entity\CRM\ProspectionInfosRepository")
 */
class ProspectionInfos
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
     * @var integer
     *
     * @ORM\Column(name="nbre_contacts", type="integer", length=255, nullable=false)
     */
    private $nbreContacts = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=1000, nullable=true)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=1000, nullable=true)
     */
    private $note = " ";
    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=1000, nullable=true)
     */
    private $url;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dernier_contact", type="date", nullable=true)
     */
    private $dernierContact;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="balcklist_today", type="date", nullable=true)
     */
    private $blacklistToday;

    /**
     * @var boolean
     *
     * @ORM\Column(name="balcklist", type="boolean", nullable=true)
     */
    private $blacklist;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CRM\Contact")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE",name="contact")
     */
    private $contact;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\CRM\Prospection")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE",name="prospection")
     */
    private $prospection;

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
     * Set nbreContacts
     *
     * @param integer $nbreContacts
     * @return ProspectionInfos
     */
    public function setNbreContacts($nbreContacts)
    {
        $this->nbreContacts = $nbreContacts;

        return $this;
    }

    /**
     * Get nbreContacts
     *
     * @return integer 
     */
    public function getNbreContacts()
    {
        return $this->nbreContacts;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return ProspectionInfos
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return ProspectionInfos
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }


    /**
     * Set company
     *
     * @param string $company
     * @return ProspectionInfos
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }


    /**
     * Set dernierContact
     *
     * @param \DateTime $dernierContact
     * @return ProspectionInfos
     */
    public function setDernierContact($dernierContact)
    {
        $this->dernierContact = $dernierContact;

        return $this;
    }

    /**
     * Get dernierContact
     *
     * @return \DateTime 
     */
    public function getDernierContact()
    {
        return $this->dernierContact;
    }

    /**
     * Set contact
     *
     * @param \AppBundle\Entity\CRM\Contact $contact
     * @return ProspectionInfos
     */
    public function setContact(\AppBundle\Entity\CRM\Contact $contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \AppBundle\Entity\CRM\Contact 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set prospection
     *
     * @param \AppBundle\Entity\CRM\Prospection $prospection
     * @return ProspectionInfos
     */
    public function setProspection(\AppBundle\Entity\CRM\Prospection $prospection)
    {
        $this->prospection = $prospection;

        return $this;
    }

    /**
     * Get prospection
     *
     * @return \AppBundle\Entity\CRM\Prospection 
     */
    public function getProspection()
    {
        return $this->prospection;
    }

    /**
     * Set blacklistToday
     *
     * @param \DateTime $blacklistToday
     * @return ProspectionInfos
     */
    public function setBlacklistToday($blacklistToday)
    {
        $this->blacklistToday = $blacklistToday;

        return $this;
    }

    /**
     * Get blacklistToday
     *
     * @return \DateTime 
     */
    public function getBlacklistToday()
    {
        return $this->blacklistToday;
    }

    /**
     * Set blacklist
     *
     * @param boolean $blacklist
     * @return ProspectionInfos
     */
    public function setBlacklist($blacklist)
    {
        $this->blacklist = $blacklist;

        return $this;
    }

    /**
     * Get blacklist
     *
     * @return boolean
     */
    public function getBlacklist()
    {
        return $this->blacklist;
    }
}
