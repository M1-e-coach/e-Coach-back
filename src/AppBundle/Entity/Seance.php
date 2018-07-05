<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 02/07/2018
 * Time: 19:56
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="seance")
 */
class Seance
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $nom;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="seances", cascade={"persist"})
     * @ORM\JoinColumn(name="coach_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Programme", inversedBy="seance", cascade={"persist"})
     * @ORM\JoinColumn(name="programme_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $programme = null;

    /**
     * @return mixed
     */
    public function getProgramme()
    {
        return $this->programme;
    }
    /**
     * @param mixed $programme
     */
    public function setProgramme($programme)
    {
        $this->programme = $programme;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @ORM\OneToMany(targetEntity="CoachPlanning", mappedBy="user")
     */
    private $coachPlannings;

    /**
     * @param mixed $coachPlannings
     */
    public function setCoachPlanning($coachPlannings)
    {
        $this->coachPlannings = $coachPlannings;
    }

    public function __construct()
    {
        $this->coachPlannings = new ArrayCollection();
    }

    public function __toString() {
        return $this->nom;
    }
}