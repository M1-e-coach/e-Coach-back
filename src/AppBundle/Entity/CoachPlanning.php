<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 03/07/2018
 * Time: 16:07
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="coach_planning")
 */
class CoachPlanning
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="text")
     */
    protected $datedebut;

    /**
     * @ORM\Column(type="text")
     */
    protected $heuredebut;

    /**
     * @ORM\Column(type="text")
     */
    protected $datefin;

    /**
     * @ORM\Column(type="text")
     */
    protected $heurefin;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $is_actif;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="coachPlannings", cascade={"persist"})
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
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * @param mixed $datedebut
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return mixed
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * @param mixed $datefin
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;
    }

    /**
     * @return mixed
     */
    public function getisActif()
    {
        return $this->is_actif;
    }

    /**
     * @param mixed $is_actif
     */
    public function setIsActif($is_actif)
    {
        $this->is_actif = $is_actif;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Seance", inversedBy="coachPlannings", cascade={"persist"})
     * @ORM\JoinColumn(name="seance_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    private $seance;

    /**
     * @return mixed
     */
    public function getSeance()
    {
        return $this->seance;
    }
    /**
     * @param mixed $seance
     */
    public function setSeance($seance)
    {
        $this->seance = $seance;
    }

    /**
     * @return mixed
     */
    public function getHeuredebut()
    {
        return $this->heuredebut;
    }

    /**
     * @param mixed $heuredebut
     */
    public function setHeuredebut($heuredebut)
    {
        $this->heuredebut = $heuredebut;
    }

    /**
     * @return mixed
     */
    public function getHeurefin()
    {
        return $this->heurefin;
    }

    /**
     * @param mixed $heurefin
     */
    public function setHeurefin($heurefin)
    {
        $this->heurefin = $heurefin;
    }
}