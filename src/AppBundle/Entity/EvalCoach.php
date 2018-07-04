<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 03/07/2018
 * Time: 15:06
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="eval_coach")
 */
class EvalCoach
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
    protected $commentaire;

    /**
     * @ORM\Column(type="integer")
     */
    protected $note;

    /**
     * @ORM\Column(type="integer")
     */
    protected $coach_id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="evalCoachs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
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
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param mixed $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @return mixed
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param mixed $note
     */
    public function setNote($note)
    {
        $this->note = $note;
    }

    /**
     * @return mixed
     */
    public function getUsercoach()
    {
        return $this->usercoach;
    }

    /**
     * @param mixed $usercoach
     */
    public function setUsercoach($usercoach)
    {
        $this->usercoach = $usercoach;
    }

    /**
     * @return mixed
     */
    public function getCoachId()
    {
        return $this->coach_id;
    }

    /**
     * @param mixed $coach_id
     */
    public function setCoachId($coach_id)
    {
        $this->coach_id = $coach_id;
    }
}