<?php

namespace EZ\FAQBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('FAQBundle:Default:index.html.twig');
    }
}
