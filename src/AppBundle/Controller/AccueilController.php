<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 27/06/2018
 * Time: 09:34
 */

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;

/**
 * Accueil controller.
 *
 * @Route("/admin")
 */
class AccueilController extends Controller
{
    /**
     * @Route("/")
     * @Template("AppBundle:Accueil:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager(); //on appelle Doctrine
        $query = $em->createQuery( //creation de la requête
            'SELECT p FROM AppBundle:Programme p ORDER BY p.id DESC'
        )->setMaxResults(3);
        $lastProgrammes = $query->getResult();

        return array(
            'lastProgrammes' => $lastProgrammes,
            'user' => $user,
            'userRoles' => $userRoles,
        );
    }
}