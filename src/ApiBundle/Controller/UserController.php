<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 03/07/2018
 * Time: 18:18
 */

namespace ApiBundle\Controller;

use AppBundle\Entity\Stat;
use AppBundle\Entity\User;
use function PHPSTORM_META\type;
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
    public function getUserAction($id, Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:User')
            ->find($id);

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
        $form = $this->createForm('AppBundle\Form\Type\UserType', $user);
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
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/users/{id}")
     * @Doc\ApiDoc(
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
     * @Doc\ApiDoc(
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

        $form = $this->createForm('AppBundle\Form\Type\UserType', $user);
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
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT u FROM AppBundle:User u WHERE u.roles LIKE :role'
        )->setParameter('role', '%"ROLE_COACH"%');

        $coachs = $query->getResult();

        /* @var $coachs Coachs[] */

        return $coachs;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/register")
     *
     *
     * @Doc\ApiDoc(
     *     section="Register",
     *     resource=true,
     *     description="Get the list of all coachs."
     * )
     */
    public function registerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        $user = new User();
        $content = $this->get('request')->getContent();
        if(!empty($content)){
            $params = json_decode($content, true);
        }

        foreach ($users as $checkuser) {
            if ($checkuser->getUsername() == $params["username"] && $checkuser->getEmail() == $params["email"]) {
                return new Response("", 409);
            }else{
                $user->setUsername($params["username"]);
                $user->setEmail($params["email"]);
                $user->setPlainPassword($params["password"]);
                $user->setPlain($params["password"]);
                $em->persist($user);
                $em->flush();
            }
        }

        return new Response("", 201);
    }

    /**
     * @Rest\View()
     * @Rest\Put("/users/infos/{id}")
     * @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="update user."
     *
     * )
     */
    public function putUsersInfoAction($id, Request $request)
    {
        $content = $this->get('request')->getContent();
        if(!empty($content)){
            $params = json_decode($content, true);
        }
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('AppBundle:User')->find($id);

        $user->setAge($params["age"]);
        $user->setPays($params["pays"]);
        $user->setLangue($params["langue"]);
        $user->setDivers($params["divers"]);

        $em->persist($user);
        $em->flush();

        return $user;
    }

    /**
     * @Rest\View()
     * @Rest\Post("/users/stats/{id}")
     *
     *
     * @Doc\ApiDoc(
     *     section="Register",
     *     resource=true,
     *     description="Get the list of all coachs."
     * )
     */
    public function postUserStatAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $stat = new Stat();
        $content = $this->get('request')->getContent();
        if(!empty($content)){
            $params = json_decode($content, true);
        }

        $stat->setUserId($params["id"]);
        $stat->setPrecision($params["precision"]);
        $stat->setCommunication($params["communication"]);
        $stat->setReflexe($params["reflexe"]);
        $stat->setMindgame($params["mindgame"]);
        $stat->setDeplacement($params["deplacement"]);

        $em->persist($stat);
        $em->flush();

        return new Response("", 201);
    }
}