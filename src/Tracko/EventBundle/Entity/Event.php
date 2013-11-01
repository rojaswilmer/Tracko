<?php

namespace Tracko\EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Tracko\EventBundle\Entity\EventRepository")
 */
class Event
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
     * @var  events
     *
     * @ORM\ManyToOne(targetEntity="Tracko\CompanyBundle\Entity\Company", inversedBy="events", cascade={"persist","remove"})
     */
    private $company;


    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="Tracko\UserBundle\Entity\User")
     * @ORM\JoinTable(name="Event_Users")
     */
    private $members;

    /**
     * @var integer
     *
     * @ORM\Column(name="founding", type="integer")
     */
    private $founding;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;


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
     * @return Event
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
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
     * Set date
     *
     * @param \DateTime $date
     * @return Event
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
     * Set members
     *
     * @param Array $members
     * @return Event
     */
    public function setMembers($members)
    {
        $this->members = $members;
    
        return $this;
    }


    /**
     * add member
     *
     * @param User $member
     * @return Event
     */
    public function addMember($member)
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * Get members
     *
     * @return integer 
     */
    public function getMembers()
    {
        return $this->members;
    }

    /**
     * Set founding
     *
     * @param integer $founding
     * @return Event
     */
    public function setFounding($founding)
    {
        $this->founding = $founding;
    
        return $this;
    }

    /**
     * Get founding
     *
     * @return integer 
     */
    public function getFounding()
    {
        return $this->founding;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return Event
     */
    public function setAddress($address)
    {
        $this->address = $address;
    
        return $this;
    }

    /**
     * Get address
     *
     * @return string 
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     *
     * @param \Tracko\EventBundle\Entity\events $company
     *
     * @return $this
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     *
     * @return \Tracko\EventBundle\Entity\events
     */
    public function getCompany()
    {
        return $this->company;
    }


}
