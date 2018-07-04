<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 03/07/2018
 * Time: 19:05
 */

namespace ApiBundle\Controller;

use AppBundle\Entity\Programme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation as Doc;

class ProgrammeController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/programmes")
     *
     *
     * @Doc\ApiDoc(
     *     section="Programmes",
     *     resource=true,
     *     description="Get the list of all programmes."
     * )
     */
    public function getProgrammesAction(Request $request)
    {
        $programmes = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Programme')
            ->findAll();
        /* @var $programmes Programmes[] */

        return $programmes;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/programmes/{id}")
     *
     * @Doc\ApiDoc(
     *     section="Programmes",
     *     resource=true,
     *     description="Get one programme.",
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
    public function getProgrammeAction($id,Request $request)
    {
        $programme=$this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Programme')
            ->find($id);


        if (empty($programme)) {
            return new JsonResponse(array('message' => 'Programme not found'), Response::HTTP_NOT_FOUND);
        }

        return $programme;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/programmes")
     * @Doc\ApiDoc(
     *     section="Programmes",
     *     resource=true,
     *     description="Post programme.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function postProgrammesAction(Request $request)
    {
        $programme = new Programme();
        $form = $this->createForm('AppBundle\Form\Type\ProgrammeType',$programme);
        $form->submit($request->request->all());

        if ($form -> isValid()){
            $em=$this->get('doctrine.orm.entity_manager');
            $em->persist($programme);
            $em->flush();
            return $programme;
        }else{
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/programmes/{id}")
     *  @Doc\ApiDoc(
     *     section="Programmes",
     *     resource=true,
     *     description="remove programme.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function removeProgrammeAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $programme = $em->getRepository('AppBundle:Programme')
            ->find($request->get('id'));
        /* @var $programme Programme */

        if ($programme) {
            $em->remove($programme);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/programmes/{id}")
     *  @Doc\ApiDoc(
     *     section="Programmes",
     *     resource=true,
     *     description="update programme."
     *
     * )
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updateProgramme($request, false);
    }

    private function updateProgramme(Request $request)
    {
        $programme = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Programme')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $programme Programme */

        if (empty($programme)) {
            return new JsonResponse(array('message' => 'Programme not found'), Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm('AppBundle\Form\Type\ProgrammeType',$programme);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($programme);
            $em->flush();
            return $programme;
        } else {
            return $form;
        }

    }
}