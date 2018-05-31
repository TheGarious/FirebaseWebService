<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/")
	 * @Template()
     */
    public function indexAction()
    {

			return [

			];
    }

	/**
	 * @param Request $request
	 *
	 * @Route("/send")
	 */
    public function sendNotificationFirebaseAction(Request $request)
	{
		$fcm = $this->get('project.service.firebase');

		$response = $fcm->sendMessageFromForm([
			'to'		=> $request->get('tokenFirebase'),
			'title'		=> $request->get('title'),
			'body'		=> $request->get('body'),
			'badge'		=> $request->get('badge'),
			'data'		=> [ $request->get('dataKey') => $request->get('dataContent')]
		], $request->get('serverKey'));

		return new JsonResponse($response, JsonResponse::HTTP_ACCEPTED);

	}
}
