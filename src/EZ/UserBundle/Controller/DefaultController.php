<?php

namespace EZ\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EZUserBundle:Default:index.html.twig');
    }
}
