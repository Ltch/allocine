<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Flex\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index(Session $session)
    {
      $session_name = $session->get("name");
      
      if (isset($session_name))
      {
        return $this->render('default/index.html.twig', array('session' => 'defined'));
      }
      return $this->render('default/index.html.twig', array());
    }
}
