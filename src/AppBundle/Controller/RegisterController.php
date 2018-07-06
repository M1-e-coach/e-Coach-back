<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 05/07/2018
 * Time: 15:50
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
use AppBundle\Form\Type\UserRegisterType;

/**
 * Class UserController
 * @Route("/register")
 */
class RegisterController extends Controller
{
    /**
     * @Route("/")
     * @Method("GET|POST")
     * @Template("AppBundle:User:register.html.twig")
     */
    public function addAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(new UserRegisterType(), $user);
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
            $user->setNote(0);
            $user->setAge(0);
            $user->setPays("");
            $user->setLangue("");
            $user->setDivers("");
            $userManager = $this->get('fos_user.user_manager');
            $user->setPlain($user->getPlainPassword());
            $userManager->updateUser($user);

            return $this->redirect($this->generateUrl('app_login_index'));
        }

        return array(
            'user' => $user,
            'form'   => $form->createView(),
        );
    }
}