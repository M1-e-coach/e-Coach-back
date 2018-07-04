<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 02/07/2018
 * Time: 20:07
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Programme;
use AppBundle\Entity\Seance;
use AppBundle\Form\Type\ProgrammeType;
use AppBundle\Form\Type\SeanceType;
use function PHPSTORM_META\type;
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
 * Class ProgrammeController
 * @Route("/admin/programme")
 */
class ProgrammeController extends Controller
{
    /**
     * @Route("/")
     * @Template("AppBundle:Programme:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $programmes = $em->getRepository('AppBundle:Programme')->findAll();

        return array(
            'userRoles' => $userRoles,
            'programmes' => $programmes,
        );
    }

    /**
     * @Route("/add")
     * @Method("GET|POST")
     * @Template("AppBundle:Programme:add.html.twig")
     */
    public function addAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $programme = new Programme();

        $form = $this->createForm(new ProgrammeType(), $programme);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $programme->setUser($this->getUser());

            $em->persist($programme);
            $em->flush();

            return $this->redirect($this->generateUrl('app_programme_addseance', array('id' => $programme->getId())));
        }

        return array(
            'form'   => $form->createView(),
            'userRoles' => $userRoles,
        );
    }

    /**
     * @Route("/add/programme/{id}/seance", requirements={"id"="\d+"})
     * @Method("GET|POST")
     * @Template("AppBundle:Programme:addseance.html.twig")
     */
    public function addSeanceAction(Request $request,$id)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $programme = $em->getRepository('AppBundle:Programme')->find($id);

        $seance = new Seance();

        $form = $this->createForm(new SeanceType(), $seance);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $seance->setUser($this->getUser());
            $seance->setProgramme($programme);

            $em->persist($seance);
            $em->flush();

            return $this->redirect($this->generateUrl('app_programme_addseance', array('id' => $programme->getId())));
        }

        return array(
            'form'   => $form->createView(),
            'userRoles' => $userRoles,
            'id' => $id,
        );
    }

    /**
     * Deletes a Programme entity.
     * @Route("/delete/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     */
    public function deleteAction(Programme $programme, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $programme = $this->getDoctrine()->getRepository('AppBundle:Programme')->find($id);

        $em->remove($programme);
        $em->flush();

        return $this->redirect($this->generateUrl('app_programme_index'));
    }

    /**
     * @Route("/update/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     * @Template("AppBundle:Programme:update.html.twig")
     */
    public function updateAction(Programme $programme, Request $request, $id)
    {
        $currentRole =  $this->getUser()->getRoles()[0];

        $editForm = $this->createForm(new ProgrammeType(), $programme, array(
            'action' => $this->generateUrl('app_programme_update', array('id' => $programme->getId())),
            'method' => 'GET'
        ));

        $em = $this->getDoctrine()->getManager();
        $seances = $em->getRepository('AppBundle:Seance')->findAll();

        if ($editForm->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($programme);
            $em->flush();

            return $this->redirect($this->generateUrl('app_programme_index', array('id' => $programme->getId())));
        }

        return array(
            'seances' => $seances,
            'programme' => $programme,
            'edit_form'   => $editForm->createView(),
            'role' => $currentRole,
        );
    }

    /**
     * @Route("/update/seance/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     * @Template("AppBundle:Programme:updateseance.html.twig")
     */
    public function updateSeanceAction(Seance $seance, Request $request, $id)
    {
        $currentRole =  $this->getUser()->getRoles()[0];

        $editForm = $this->createForm(new SeanceType(), $seance, array(
            'action' => $this->generateUrl('app_programme_updateseance', array('id' => $seance->getId())),
            'method' => 'GET'
        ));

        if ($editForm->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($seance);
            $em->flush();

            return $this->redirect($this->generateUrl('app_programme_index', array('id' => $seance->getId())));
        }

        return array(
            'seance' => $seance,
            'edit_form'   => $editForm->createView(),
            'role' => $currentRole,
        );
    }

    /**
     * @Route("/vue/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     * @Template("AppBundle:Programme:vue.html.twig")
     */
    public function vueAction(Programme $programme, Request $request, $id){
        $currentRole =  $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $programme = $em->getRepository('AppBundle:Programme')->findBy(array('id' => $id));

        $seances = $em->getRepository('AppBundle:Seance')->findAll();

        return array(
            'seances' => $seances,
            'programme' => $programme,
            'role' => $currentRole,
        );
    }
}