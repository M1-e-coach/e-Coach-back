<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 03/07/2018
 * Time: 16:05
 */

namespace AppBundle\Controller;

use AppBundle\Entity\CoachPlanning;
use AppBundle\Form\Type\CoachPlanningType;
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
 * @Route("/admin/coach")
 */
class CoachPlanningController extends Controller
{
    /**
     * @Route("/")
     * @Template("AppBundle:Coach:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $coachPlannings = $em->getRepository('AppBundle:CoachPlanning')->findAll();

        return array(
            'userRoles' => $userRoles,
            'coachPlannings' => $coachPlannings,
        );
    }
}