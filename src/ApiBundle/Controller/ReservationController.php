<?php


namespace ApiBundle\Controller;


use AppBundle\Entity\Commande;
use AppBundle\Entity\Stat;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\View\ViewHandler;
use FOS\RestBundle\View\View; // Utilisation de la vue de FOSRestBundle
use Nelmio\ApiDocBundle\Annotation as Doc;


class ReservationController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Put("/commande/{id}")
     * @Doc\ApiDoc(
     *     section="Users",
     *     resource=true,
     *     description="update user.",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The article unique identifier."
     *         }
     *     }
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
        $sql = 'INSERT INTO `commande`(`user_id`, `precision`, `mindgame`, `deplacement`, `communication`, `reflexe`, `eventid`, `seancesolo`) 
        VALUES ('.$id.', '.$params["precision"].', '.$params["mindgame"].', 
        '.$params["deplacement"].', '.$params["communication"].', '.$params["reflexe"].', '.$params["eventId"].', '.$params["seanceSoloId"].')';
        $stmt = $em->getConnection()->prepare($sql);
        $commande = $stmt->execute();

        return $commande;
    }

    /**
     * @Rest\View()
     * @Rest\Put("/stat/{id}")
     * @Doc\ApiDoc(
     *     section="Stats",
     *     resource=true,
     *     description="update stat."
     *
     * )
     */
    public function putStatAction($id, Request $request)
    {
        $content = $this->get('request')->getContent();
        if(!empty($content)){
            $paramsS = json_decode($content, true);
        }
        $em = $this->getDoctrine()->getManager();
        //$stat = New Stat();

        /*$stat->setPrecision($paramsS["precision"]);
        $stat->setMindgame($paramsS["mindgame"]);
        $stat->setDeplacement($paramsS["deplacement"]);
        $stat->setCommunication($paramsS["communication"]);
        $stat->setReflexe($paramsS["reflexe"]);*/

        $entityManager = $this->getDoctrine()->getManager();
        $sql = 'INSERT INTO `stat`(`precision`, `mindgame`, `deplacement`, `communication`, `reflexe`, `userid`) 
        VALUES ('.$paramsS["precision"].', '.$paramsS["mindgame"].', '.$paramsS["deplacement"].', 
        '.$paramsS["communication"].', '.$paramsS["reflexe"].', '.$id.')';
        $stmt = $em->getConnection()->prepare($sql);
        $stat = $stmt->execute();

        /*$em->persist($request);
        $em->flush();*/

        return $stat;
    }
}