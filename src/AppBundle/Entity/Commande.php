<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 06/07/2018
 * Time: 10:47
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="commande")
 */
class Commande
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
    protected $userid;

    /**
     * @ORM\Column(type="integer")
     */
    protected $eventid;

    /**
     * @ORM\Column(type="integer")
     */
    protected $statid;

    /**
     * @ORM\Column(type="integer")
     */
    protected $programmeid;

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

    /**
     * @return mixed
     */
    public function getEventid()
    {
        return $this->eventid;
    }

    /**
     * @param mixed $eventid
     */
    public function setEventid($eventid)
    {
        $this->eventid = $eventid;
    }

    /**
     * @return mixed
     */
    public function getStatid()
    {
        return $this->statid;
    }

    /**
     * @param mixed $statid
     */
    public function setStatid($statid)
    {
        $this->statid = $statid;
    }

    /**
     * @return mixed
     */
    public function getProgrammeid()
    {
        return $this->programmeid;
    }

    /**
     * @param mixed $programmeid
     */
    public function setProgrammeid($programmeid)
    {
        $this->programmeid = $programmeid;
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
}