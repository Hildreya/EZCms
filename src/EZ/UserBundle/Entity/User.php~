<?php

namespace EZ\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="extaz_user")
 * @ORM\Entity(repositoryClass="EZ\UserBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="minecraft_username", type="string", nullable=true)
     */
    protected $minecraftUsername;

    /**
     * @ORM\ManyToMany(targetEntity="EZ\UserBundle\Entity\Group")
     * @ORM\JoinTable(name="extaz_user_user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;

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
     * Set minecraftUsername
     *
     * @param string $minecraftUsername
     *
     * @return User
     */
    public function setMinecraftUsername($minecraftUsername)
    {
        $this->minecraftUsername = $minecraftUsername;

        return $this;
    }

    /**
     * Get minecraftUsername
     *
     * @return string
     */
    public function getMinecraftUsername()
    {
        return $this->minecraftUsername;
    }
}
