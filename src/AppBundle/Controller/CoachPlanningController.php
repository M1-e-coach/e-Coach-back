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

        $userId = $this->getUser()->getId();

        $em = $this->getDoctrine()->getManager();
        $coachPlannings = $em->getRepository('AppBundle:CoachPlanning')->findBy(array('user'=>$userId));
        /*$query = $em->createQuery(
            'SELECT cp FROM AppBundle:CoachPlanning cp WHERE u.id ='.$userId
        );*/

        //$coachPlannings = $query->getResult();

        return array(
            'userRoles' => $userRoles,
            'userId' => $userId,
            'coachPlannings' => $coachPlannings,
        );
    }

    /**
     * @Route("/add")
     * @Method("GET|POST")
     * @Template("AppBundle:Coach:add.html.twig")
     */
    public function addAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $coachs = $em->getRepository('AppBundle:CoachPlanning')->findAll();

        $coach = new CoachPlanning();
        $form = $this->createForm(new CoachPlanningType(), $coach);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $coach->setUser($this->getUser());
            $coach->setIsActif(true);
            $em->persist($coach);
            $em->flush();

            return $this->redirect($this->generateUrl('app_coachplanning_index'));
        }

        return array(
            'form'   => $form->createView(),
            'userRoles' => $userRoles,
            'coachs' => $coachs,
        );
    }
}