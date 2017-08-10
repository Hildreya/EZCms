<?php

namespace EZ\SupportBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Support
 *
 * @ORM\Table(name="support")
 * @ORM\Entity(repositoryClass="EZ\SupportBundle\Repository\SupportRepository")
 */
class Support
{
    /*
     * Priorités
     */
    const BASSE = 0;
    const MOYENNE = 1;
    const HAUTE = 2;
    const TRES_HAUTE = 3;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \EZ\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="EZ\UserBundle\Entity\User")
     */
    private $userId;

    /**
     * @var int
     * @ORM\Column(name="categorie", type="integer")
     */
    private $categorie;

    /**
     * @var int
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=2000, nullable=true)
     */
    private $message;

    /**
     * @var bool
     *
     * @ORM\Column(name="resolved", type="boolean")
     */
    private $resolved = 0;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date", type="datetime")
     */
    private $createdDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="update_date", type="datetime")
     */
    private $updateDate;


    /**
     * One Ticket has many response
     * @ORM\OneToMany(targetEntity="EZ\SupportBundle\Entity\Support_reponse", mappedBy="ticketId")
     */
    private $reponse;

    public function __construct()
    {
        $this->createdDate = new \DateTime();
        $this->updateDate = new \DateTime();
        $this->reponse = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set priority
     *
     * @param integer $priority
     *
     * @return Support
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return Support
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set resolved
     *
     * @param boolean $resolved
     *
     * @return Support
     */
    public function setResolved($resolved)
    {
        $this->resolved = $resolved;

        return $this;
    }

    /**
     * Get resolved
     *
     * @return bool
     */
    public function getResolved()
    {
        return $this->resolved;
    }

    /**
     * Set createdDate
     *
     * @param \DateTime $createdDate
     *
     * @return Support
     */
    public function setCreatedDate($createdDate)
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    /**
     * Get createdDate
     *
     * @return \DateTime
     */
    public function getCreatedDate()
    {
        return $this->createdDate;
    }

    /**
     * Set updateDate
     *
     * @param \DateTime $updateDate
     *
     * @return Support
     */
    public function setUpdateDate($updateDate)
    {
        $this->updateDate = $updateDate;

        return $this;
    }

    /**
     * Get updateDate
     *
     * @return \DateTime
     */
    public function getUpdateDate()
    {
        return $this->updateDate;
    }

    /**
     * Set categorie
     *
     * @param integer $categorie
     *
     * @return Support
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return integer
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set userId
     *
     * @param \EZ\UserBundle\Entity\User $userId
     *
     * @return Support
     */
    public function setUserId(\EZ\UserBundle\Entity\User $userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return \EZ\UserBundle\Entity\User
     */
    public function getUserId()
    {
        return $this->userId;
    }

    public function priorityToString()
    {
        $text= '';
        if($this->priority = Support::BASSE){
            $text='faible';
        }
        elseif ($this->priority = Support::MOYENNE){
            $text='moyenne';
        }
        elseif ($this->priority = Support::HAUTE){
            $text='haute';
        }
        elseif ($this->priority = Support::TRES_HAUTE){
            $text='très haute';
        }
        return 'Priorité '.$text;
    }

    /**
     * Add reponse
     *
     * @param \EZ\SupportBundle\Entity\Support_reponse $reponse
     *
     * @return Support
     */
    public function addReponse(\EZ\SupportBundle\Entity\Support_reponse $reponse)
    {
        $this->reponse[] = $reponse;

        return $this;
    }

    /**
     * Remove reponse
     *
     * @param \EZ\SupportBundle\Entity\Support_reponse $reponse
     */
    public function removeReponse(\EZ\SupportBundle\Entity\Support_reponse $reponse)
    {
        $this->reponse->removeElement($reponse);
    }

    /**
     * Get reponse
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReponse()
    {
        return $this->reponse;
    }
}
