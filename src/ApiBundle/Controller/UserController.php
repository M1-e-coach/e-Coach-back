<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 03/07/2018
 * Time: 18:18
 */

namespace ApiBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation as Doc;


class UserController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/users")
     *
     *
     * @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="Get the list of all users."
     * )
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->findAll();
        /* @var $users Users[] */

        return $users;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/users/{id}")
     *
     * @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="Get one user.",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The article unique identifier."
     *         }
     *     }
     * )
     */
    public function getUserAction($id,Request $request)
    {
        $user=$this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->find($id);


        if (empty($user)) {
            return new JsonResponse(array('message' => 'User not found'), Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/users")
     * @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="Post user.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function postUsersAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('AppBundle\Form\Type\UserType',$user);
        $form->submit($request->request->all());

        if ($form -> isValid()){
            $em=$this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        }else{
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/users/{id}")
     *  @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="remove user.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function removeUserAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('AppBundle:User')
            ->find($request->get('id'));
        /* @var $user User */

        if ($user) {
            $em->remove($user);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/users/{id}")
     *  @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="update user."
     *
     * )
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updateUser($request, false);
    }

    private function updateUser(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user User */

        if (empty($user)) {
            return new JsonResponse(array('message' => 'User not found'), Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm('AppBundle\Form\Type\UserType',$user);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }

    }

    /**
     * @Rest\View()
     * @Rest\Get("/coachs")
     *
     *
     * @Doc\ApiDoc(
     *     section="Coachs",
     *     resource=true,
     *     description="Get the list of all coachs."
     * )
     */
    public function getCoachsAction(Request $request)
    {
        /*$coachs = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->findBy(array('roles' => ''));*/
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT u FROM AppBundle:User u WHERE u.roles LIKE :role'
        )->setParameter('role', '%"ROLE_COACH"%');

        $coachs = $query->getResult();

        /* @var $coachs Coachs[] */

        return $coachs;
    }
}