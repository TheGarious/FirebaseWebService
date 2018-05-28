<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

	}
}
