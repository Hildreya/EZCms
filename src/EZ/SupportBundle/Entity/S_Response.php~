<?php

namespace EZ\SupportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Support_reponse
 *
 * @ORM\Table(name="support_reponse")
 * @ORM\Entity(repositoryClass="EZ\SupportBundle\Repository\Support_reponseRepository")
 */
class S_Response
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=2000)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="EZ\SupportBundle\Entity\Support", inversedBy="reponse")
     * @ORM\JoinColumn(nullable=false)
     */

    private $ticket;

    /**
     * @var DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var \EZ\UserBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="EZ\UserBundle\Entity\User")
     */
    private $user;

    public function __construct()
    {
        $this->date = new \DateTime();
    }

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
     * Set message
     *
     * @param string $message
     *
     * @return SResponse
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return SResponse
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set ticket
     *
     * @param \EZ\SupportBundle\Entity\Support $ticket
     *
     * @return SResponse
     */
    public function setTicket(\EZ\SupportBundle\Entity\Support $ticket)
    {
        $this->ticket = $ticket;

        return $this;
    }

    /**
     * Get ticket
     *
     * @return \EZ\SupportBundle\Entity\Support
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * Set user
     *
     * @param \EZ\UserBundle\Entity\User $user
     *
     * @return SResponse
     */
    public function setUser(\EZ\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \EZ\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
