<?php

namespace Hamdi\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HamdiContactBundle:Default:index.html.twig', array('name' => $name));
    }
}
