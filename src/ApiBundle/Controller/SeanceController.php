<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 03/07/2018
 * Time: 19:15
 */

namespace ApiBundle\Controller;

use AppBundle\Entity\Seance;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation as Doc;

class SeanceController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/seances")
     *
     *
     * @Doc\ApiDoc(
     *     section="Seances",
     *     resource=true,
     *     description="Get the list of all seances."
     * )
     */
    public function getSeancesAction(Request $request)
    {
        $seances = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Seance')
            ->findAll();
        /* @var $seances Seances[] */

        return $seances;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/seances/{id}")
     *
     * @Doc\ApiDoc(
     *     section="Seances",
     *     resource=true,
     *     description="Get one seance.",
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
    public function getSeanceAction($id,Request $request)
    {
        $seance=$this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Seance')
            ->find($id);


        if (empty($seance)) {
            return new JsonResponse(array('message' => 'Seance not found'), Response::HTTP_NOT_FOUND);
        }

        return $seance;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/seances")
     * @Doc\ApiDoc(
     *     section="Seances",
     *     resource=true,
     *     description="Post seance.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function postSeancesAction(Request $request)
    {
        $seance = new Seance();
        $form = $this->createForm('AppBundle\Form\Type\SeanceType',$seance);
        $form->submit($request->request->all());

        if ($form -> isValid()){
            $em=$this->get('doctrine.orm.entity_manager');
            $em->persist($seance);
            $em->flush();
            return $seance;
        }else{
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/seances/{id}")
     *  @Doc\ApiDoc(
     *     section="Seances",
     *     resource=true,
     *     description="remove seance.",
     *     statusCodes={
     *         201="Returned when created",
     *         400="Returned when a violation is raised by validation"
     *     }
     *
     * )
     */
    public function removeSeanceAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $seance = $em->getRepository('AppBundle:Seance')
            ->find($request->get('id'));
        /* @var $seance Seance */

        if ($seance) {
            $em->remove($seance);
            $em->flush();
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/seances/{id}")
     *  @Doc\ApiDoc(
     *     section="Seances",
     *     resource=true,
     *     description="update seance."
     *
     * )
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updateSeance($request, false);
    }

    private function updateSeance(Request $request)
    {
        $seance = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Seance')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $seance Seance */

        if (empty($seance)) {
            return new JsonResponse(array('message' => 'Seance not found'), Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm('AppBundle\Form\Type\SeanceType',$seance);
        $form->submit($request->request->all());
        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($seance);
            $em->flush();
            return $seance;
        } else {
            return $form;
        }

    }
}