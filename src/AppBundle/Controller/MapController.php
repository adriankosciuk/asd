<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Marker;

class MapController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        //pobieram wszystkie markery lokalizacji
        $repository = $this->getDoctrine()->getRepository('AppBundle:Marker');
        $markers = $repository->findAll();
        
        return $this->render('map/map.html.twig', [
                    'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
                    'markers' => $markers
        ]);
    }

    public function saveCoordinatesAction(Request $request) {
        //poobieram dane z ajax
        $content = $request->getContent();
        $params = json_decode($content, true);
        //tworzę nowy marker o współrzednych pobranych z ajax
        $marker = new Marker();
        $marker->setName($params["name"]);
        $marker->setLng($params["lng"]);
        $marker->setLat($params["lat"]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($marker);
        $em->flush();
        
        return new Response($marker->getId());
    }

    public function deleteCoordinatesAction(Request $request) {

        $content = $request->getContent();
        $params = json_decode($content, true);
        
        $repository = $this->getDoctrine()->getRepository('AppBundle:Marker');
        $marker = $repository->findOneBy(array('id' => $params['id']));
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($marker);
        $em->flush();

        return new Response($marker->getId());
    }

}
