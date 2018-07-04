<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 03/07/2018
 * Time: 15:23
 */

namespace AppBundle\Controller;

use AppBundle\Entity\EvalProgramme;
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
 * @Route("/admin/eval/programme")
 */
class EvalProgrammeController extends Controller
{
    /**
     * @Route("/")
     * @Template("AppBundle:EvalProgramme:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $userRoles = $this->getUser()->getRoles()[0];

        $em = $this->getDoctrine()->getManager();
        $evalProgrammes = $em->getRepository('AppBundle:EvalProgramme')->findAll();

        return array(
            'userRoles' => $userRoles,
            'evalProgrammes' => $evalProgrammes,
        );
    }

    /**
     * @Route("/delete/{id}", requirements={"id"="\d+"})
     * @Method("GET|POST")
     */
    public function deleteAction(EvalProgramme $evalProgramme, Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $evalProgramme = $this->getDoctrine()->getRepository('AppBundle:EvalProgramme')->find($id);

        $em->remove($evalProgramme);
        $em->flush();

        return $this->redirect($this->generateUrl('app_evalprogramme_index'));
    }
}