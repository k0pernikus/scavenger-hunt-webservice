<?php

namespace Scavenger\WebserviceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\ORM\Mapping\OneToMany;
use \Doctrine\ORM\Mapping\ManyToMany;
use \Doctrine\ORM\Mapping\JoinTable;
use \Doctrine\ORM\Mapping\JoinColumn;

/**
 * Scavenger\WebserviceBundle\Entity\User
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Scavenger\WebserviceBundle\Entity\UserRepository")
 */
class User
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
     * @var string $device_id
     *
     * @ORM\Column(name="device_id", type="string", length=255)
     */
    private $device_id;

    /**
     * @OneToMany(targetEntity="Scavenger\WebserviceBundle\Entity\UserLocation", mappedBy="user")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $locations;

    /**
     * @ManyToMany(targetEntity="Scavenger\WebserviceBundle\Entity\Session", inversedBy="users")
     * @JoinTable(name="Session_has_User",
     *      joinColumns={@JoinColumn(name="session_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $sessions;

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
     * Set device_id
     *
     * @param string $deviceId
     */
    public function setDeviceId($deviceId)
    {
        $this->device_id = $deviceId;
    }

    /**
     * Get device_id
     *
     * @return string
     */
    public function getDeviceId()
    {
        return $this->device_id;
    }

    /**
     * @return \Scavenger\WebserviceBundle\Entity\Location[]
     */
    public function getLocations()
    {
        return $this->locations;
    }

    /**
     * @return \Scavenger\WebserviceBundle\Entity\Session[]
     */
    public function getSessions()
    {
        return $this->sessions;
    }
}