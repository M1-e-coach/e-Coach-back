<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 04/07/2018
 * Time: 09:57
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Jeu;
use AppBundle\Entity\Programme;
use AppBundle\Entity\Seance;
use AppBundle\Form\Type\JeuType;
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
 * @Route("/admin/jeux")
 */
class JeuxController extends Controller
{
    /**
     * @Route("/")
     * @Template("AppBundle:Jeux:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $jeux = $em->getRepository('AppBundle:Jeu')->findAll();

        return array(
            'userRoles' => $userRoles,
            'jeux' => $jeux,
        );
    }

    /**
     * @Route("/add")
     * @Method("GET|POST")
     * @Template("AppBundle:Jeux:add.html.twig")
     */
    public function addAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $jeu = new Jeu();

        $form = $this->createForm(new JeuType(), $jeu);
        if ($form->handleRequest($request)->isValid()) {

            $file = $jeu->getImage();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->container->getParameter('image_directory'),
                $fileName
            );
            $jeu->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($jeu);
            $em->flush();

            return $this->redirect($this->generateUrl('app_jeux_index'));
        }

        return array(
            'form'   => $form->createView(),
            'userRoles' => $userRoles,
        );
    }

    /**
     * Deletes a Jeu entity.
     * @Route("/delete/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     */
    public function deleteAction(Jeu $jeu, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $jeu = $this->getDoctrine()->getRepository('AppBundle:Jeu')->find($id);

        $em->remove($jeu);
        $em->flush();

        return $this->redirect($this->generateUrl('app_jeux_index'));
    }
}