<?php
/**
 * Created by PhpStorm.
 * User: Guillaume
 * Date: 13/03/2018
 * Time: 16:40
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->seances = new ArrayCollection();
        $this->programmes = new ArrayCollection();
        $this->evalCoachs = new ArrayCollection();
        $this->evalProgrammes = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $nb_coin = 0;

    /**
     * @return mixed
     */
    public function getNbCoin()
    {
        return $this->nb_coin;
    }

    /**
     * @param mixed $nb_coin
     */
    public function setNbCoin($nb_coin)
    {
        $this->nb_coin = $nb_coin;
    }

    /**
     * @ORM\OneToMany(targetEntity="Seance", mappedBy="user", cascade={"remove"}, orphanRemoval=true)
     */
    protected $seances;

    /**
     * @param mixed $seances
     */
    public function setSeances($seances)
    {
        $this->seances = $seances;
    }

    /**
     * @ORM\OneToMany(targetEntity="Programme", mappedBy="user", cascade={"remove"}, orphanRemoval=true)
     */
    protected $programmes;

    /**
     * @param mixed $programmes
     */
    public function setPrgorammes($programmes)
    {
        $this->programmes = $programmes;
    }

    /**
     * @ORM\OneToMany(targetEntity="EvalCoach", mappedBy="user")
     */
    protected $evalCoachs;

    /**
     * @param mixed $evalCoachs
     */
    public function setEvalCoach($evalCoachs)
    {
        $this->evalCoachs = $evalCoachs;
    }

    /**
     * @ORM\OneToMany(targetEntity="EvalProgramme", mappedBy="user")
     */
    protected $evalProgrammes;

    /**
     * @param mixed $evalProgrammes
     */
    public function setEvalProgramme($evalProgrammes)
    {
        $this->evalProgrammes = $evalProgrammes;
    }

    /**
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    protected $image = '';

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @ORM\Column(type="string")
     */
    protected $plain;

    /**
     * @return mixed
     */
    public function getPlain()
    {
        return $this->plain;
    }

    /**
     * @param mixed $plain
     */
    public function setPlain($plain)
    {
        $this->plain = $plain;
    }
}