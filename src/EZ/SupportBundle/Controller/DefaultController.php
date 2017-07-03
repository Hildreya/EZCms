<?php

namespace EZ\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EZSupportBundle:Default:index.html.twig');
    }
}
