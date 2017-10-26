<?php
namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Client;

class ClientController extends Controller
{

    public function getClientsAction(Request $request)
    {
        $places = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Client')
                ->findAll();
        /* @var $places Client[] */

        $formatted = [];
        foreach ($places as $place) {
            $formatted[] = [
               'id' => $place->getId(),
               'id_insta' => $place->getIdInsta(),
            ];
        }

        return new JsonResponse($formatted);
    }

    public function getClientAction($id, Request $request)
    {
        $place = $this->get('doctrine.orm.entity_manager')
                ->getRepository('AppBundle:Client')
                ->find($id);
        /* @var $place Client */

        if (empty($place)) {
            return new JsonResponse(['message' => 'Client not found'], Response::HTTP_NOT_FOUND);
        }

        $formatted = [
           'id' => $place->getId(),
           'id_insta' => $place->getIdInsta(),
        ];

        return new JsonResponse($formatted);
    }
}
