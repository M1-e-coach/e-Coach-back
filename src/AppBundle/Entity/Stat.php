<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 05/07/2018
 * Time: 19:22
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="stat")
 */
class Stat
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $precision;

    /**
     * @ORM\Column(type="integer")
     */
    protected $mindgame;

    /**
     * @ORM\Column(type="integer")
     */
    protected $deplacement;

    /**
     * @ORM\Column(type="integer")
     */
    protected $communication;

    /**
     * @ORM\Column(type="integer")
     */
    protected $reflexe;

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
    public function getPrecision()
    {
        return $this->precision;
    }

    /**
     * @param mixed $precision
     */
    public function setPrecision($precision)
    {
        $this->precision = $precision;
    }

    /**
     * @return mixed
     */
    public function getMindgame()
    {
        return $this->mindgame;
    }

    /**
     * @param mixed $mindgame
     */
    public function setMindgame($mindgame)
    {
        $this->mindgame = $mindgame;
    }

    /**
     * @return mixed
     */
    public function getDeplacement()
    {
        return $this->deplacement;
    }

    /**
     * @param mixed $deplacement
     */
    public function setDeplacement($deplacement)
    {
        $this->deplacement = $deplacement;
    }

    /**
     * @return mixed
     */
    public function getCommunication()
    {
        return $this->communication;
    }

    /**
     * @param mixed $communication
     */
    public function setCommunication($communication)
    {
        $this->communication = $communication;
    }

    /**
     * @return mixed
     */
    public function getReflexe()
    {
        return $this->reflexe;
    }

    /**
     * @param mixed $reflexe
     */
    public function setReflexe($reflexe)
    {
        $this->reflexe = $reflexe;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $userid;

    /**
     * @return mixed
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param mixed $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }
}