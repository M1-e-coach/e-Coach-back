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
    private $seances;

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
    private $programmes;

    /**
     * @param mixed $programmes
     */
    public function setPrgorammes($programmes)
    {
        $this->programmes = $programmes;
    }
}