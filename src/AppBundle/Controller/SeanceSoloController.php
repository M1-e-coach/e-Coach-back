<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 05/07/2018
 * Time: 12:04
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\SeanceSoloType;
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
use AppBundle\Entity\SeanceSolo;

/**
 * Accueil controller.
 *
 * @Route("/admin/seancesolo")
 */
class SeanceSoloController extends Controller
{
    /**
     * @Route("/")
     * @Template("AppBundle:Seancesolo:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $seancesolos = $em->getRepository('AppBundle:SeanceSolo')->findBy(array('user'=>$this->getUser()->getId()));

        return array(
            'seancesolos' => $seancesolos,
            'user' => $user,
            'userRoles' => $userRoles,
        );
    }

    /**
     * @Route("/add")
     * @Method("GET|POST")
     * @Template("AppBundle:Seancesolo:add.html.twig")
     */
    public function addAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $seancesolo = new SeanceSolo();

        $form = $this->createForm(new SeanceSoloType(), $seancesolo);
        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $seancesolo->setUser($this->getUser());

            $em->persist($seancesolo);
            $em->flush();

            return $this->redirect($this->generateUrl('app_seancesolo_index'));
        }

        return array(
            'form'   => $form->createView(),
            'userRoles' => $userRoles,
        );
    }

    /**
     * Deletes a Programme entity.
     * @Route("/delete/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     */
    public function deleteAction(SeanceSolo $seanceSolo, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $seanceSolo = $this->getDoctrine()->getRepository('AppBundle:SeanceSolo')->find($id);

        $em->remove($seanceSolo);
        $em->flush();

        return $this->redirect($this->generateUrl('app_seancesolo_index'));
    }

    /**
     * @Route("/update/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     * @Template("AppBundle:SeanceSolo:update.html.twig")
     */
    public function updateAction(SeanceSolo $seanceSolo, Request $request, $id)
    {
        $userRoles =  $this->getUser()->getRoles()[0];

        $editForm = $this->createForm(new SeanceSoloType(), $seanceSolo, array(
            'action' => $this->generateUrl('app_seancesolo_update', array('id' => $seanceSolo->getId())),
            'method' => 'GET'
        ));

        if ($editForm->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($seanceSolo);
            $em->flush();

            return $this->redirect($this->generateUrl('app_seancesolo_index'));
        }

        return array(
            'edit_form'   => $editForm->createView(),
            'userRoles' => $userRoles,
        );
    }
}