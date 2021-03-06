<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 04/07/2018
 * Time: 09:59
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="jeu")
 */
class Jeu
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
     * @ORM\OneToMany(targetEntity="User", mappedBy="jeu")
     */
    private $users;

    /**
     * @param mixed $users
     */
    public function setUser($users)
    {
        $this->users = $users;
    }

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @ORM\Column(type="string")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $image;

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

    public function __toString() {
        return $this->nom;
    }
}