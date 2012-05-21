<?php

namespace Scavenger\WebserviceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\ORM\Mapping\ManyToMany;
use \Doctrine\ORM\Mapping\JoinTable;
use \Doctrine\ORM\Mapping\JoinColumn;

/**
 * Scavenger\WebserviceBundle\Entity\Session
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Scavenger\WebserviceBundle\Entity\SessionRepository")
 */
class Session
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer $mrX
     *
     * @ORM\Column(name="mrX", type="integer")
     */
    private $mrX;


    /**
     * @ManyToMany(targetEntity="Scavenger\WebserviceBundle\Entity\User")
     * @JoinTable(name="Session_has_User",
     *      joinColumns={@JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="session_id", referencedColumnName="id")}
     * )
     */
    private $users;


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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set mrX
     *
     * @param integer $mrX
     */
    public function setMrX($mrX)
    {
        $this->mrX = $mrX;
    }

    /**
     * Get mrX
     *
     * @return integer 
     */
    public function getMrX()
    {
        return $this->mrX;
    }

    /**
     * @return Scavenger\WebserviceBundle\Entity\User[]
     */
    public function getUsers()
    {
        return $this->users;
    }
}