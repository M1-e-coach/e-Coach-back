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
            $coach->setDatedebut(date("Y-m-d"));
            $coach->setDatefin(date("Y-m-d"));
            $coach->setHeuredebut(date("H:i:s"));
            $coach->setHeurefin(date("H:i:s"));
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

    /**
     * @Route("/update/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     * @Template("AppBundle:Programme:update.html.twig")
     */
    public function updateAction(CoachPlanning $coachPlanning, Request $request, $id)
    {
        $userRoles =  $this->getUser()->getRoles()[0];

        $editForm = $this->createForm(new CoachPlanningType(), $coachPlanning, array(
            'action' => $this->generateUrl('app_programme_update', array('id' => $coachPlanning->getId())),
            'method' => 'GET'
        ));

        if ($editForm->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($coachPlanning);
            $em->flush();

            return $this->redirect($this->generateUrl('app_coachplanning_index'));
        }

        return array(
            'edit_form'   => $editForm->createView(),
            'userRoles' => $userRoles,
        );
    }

    /**
     * Deletes a Jeu entity.
     * @Route("/delete/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     */
    public function deleteAction(CoachPlanning $coachPlanning, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $coachPlanning = $this->getDoctrine()->getRepository('AppBundle:CoachPlanning')->find($id);

        $em->remove($coachPlanning);
        $em->flush();

        return $this->redirect($this->generateUrl('app_coachplanning_index'));
    }
}