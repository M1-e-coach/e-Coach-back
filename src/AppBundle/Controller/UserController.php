<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 28/06/2018
 * Time: 09:15
 */

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\Seance;
use AppBundle\Form\Type\UserType;
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
 * Class UserController
 * @Route("/admin/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/")
     * @Template("AppBundle:User:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        return array(
            'userRoles' => $userRoles,
            'users' => $users,
        );
    }

    /**
     * @Route("/add")
     * @Method("GET|POST")
     * @Template("AppBundle:User:add.html.twig")
     */
    public function addAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        $user = new User();
        $form = $this->createForm(new UserType(), $user);
        if ($form->handleRequest($request)->isValid()) {

            $file = $user->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->container->getParameter('image_coach_directory'),
                $fileName
            );
            $user->setImage($fileName);

            $user->setEnabled(true);
            $user->setNote(0);
            $user->setAge(0);
            $user->setPays("");
            $user->setLangue("");
            $user->setDivers("");
            $userManager = $this->get('fos_user.user_manager');
            $user->setPlain($user->getPlainPassword());
            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('app_user_index'));
        }

        return array(
            'user' => $user,
            'form'   => $form->createView(),
            'userRoles' => $userRoles,
            'users' => $users,
        );
    }

    /**
     * Deletes a User entity.
     * @Route("/delete/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     */
    public function deleteAction(User $user, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        $em->remove($user);
        $em->flush();

        return $this->redirect($this->generateUrl('app_user_index'));
    }

    /**
     * @Route("/update/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     * @Template("AppBundle:User:update.html.twig")
     */
    public function updateAction(User $user, Request $request, $id)
    {
        $userRoles =  $this->getUser()->getRoles()[0];
        $editForm = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('app_user_update', array('id' => $user->getId())),
            'method' => 'GET',
            'passwordRequired' => false
        ));
        if ($editForm->handleRequest($request)->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('app_user_index', array('id' => $user->getId())));
        }

        return array(
            'user' => $user,
            'edit_form'   => $editForm->createView(),
            'userRoles' => $userRoles,
        );
    }
}