<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 04/07/2018
 * Time: 22:08
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

class LoginController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Post("/login")
     *
     *
     * @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="Get the list of all users."
     * )
     */
    public function loginAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('AppBundle:User')->findAll();

        $content = $this->get('request')->getContent();

        if(!empty($content)){
            $params = json_decode($content, true);
        }

        foreach ($users as $user) {
            if($user->getEmail() == $params["email"]){
                if($user->getPlain() == $params["password"]){
                    return $user;
                }
            }
        }

        return new Response(403);
    }
}