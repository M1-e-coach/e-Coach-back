<?php
/**
 * Created by PhpStorm.
 * User: PC-Guillaume
 * Date: 05/07/2018
 * Time: 14:40
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

class CoachController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/coachs/{id}")
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
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT u FROM AppBundle:User u WHERE u.roles LIKE :role AND u.id = :id'
        )
            ->setParameter('role', '%"ROLE_COACH"%')
            ->setParameter('id', $id)
        ;
        $coachs = $query->getResult();

        $queryProgrammes = $entityManager->createQuery(
            'SELECT p, s FROM AppBundle:Seance s, AppBundle:User u, AppBundle:Programme p WHERE u.id = :id AND p.user = :id AND s.user = :id AND u.roles LIKE :role'
        )
            ->setParameter('role', '%"ROLE_COACH"%')
            ->setParameter('id', $id)
        ;
        $coachProgrammes = $queryProgrammes->getResult();

        $querySeanceSolo = $entityManager->createQuery(
            'SELECT ss FROM AppBundle:SeanceSolo ss, AppBundle:User u WHERE u.id = :id AND ss.user = :id AND u.roles LIKE :role'
        )
            ->setParameter('role', '%"ROLE_COACH"%')
            ->setParameter('id', $id)
        ;
        $coachsSeanceSolos = $querySeanceSolo->getResult();

        return array(
            'coachInfos' => $coachs,
            'coachProgrammes' => $coachProgrammes,
            'coachSeanceSolos' => $coachsSeanceSolos
        );
    }

    /**
     * @Rest\View()
     * @Rest\Get("/coachs/jeu/{nom}")
     *
     * @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="Get one user.",
     *     requirements={
     *         {
     *             "name"="nom",
     *             "dataType"="string",
     *             "requirements"="\d+",
     *             "description"="The article unique identifier."
     *         }
     *     }
     * )
     */
    public function getGameAction($nom, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $query = $entityManager->createQuery(
            'SELECT u FROM AppBundle:User u, AppBundle:Jeu j WHERE u.jeu = j.id AND j.nom = :nom AND  u.roles LIKE :role'
        )
            ->setParameter('role', '%"ROLE_COACH"%')
            ->setParameter('nom', $nom)
        ;
        $coachsJeu = $query->getResult();

        return array(
            'CoachsByJeu' => $coachsJeu
        );
    }
}