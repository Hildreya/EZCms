<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MainController extends Controller
{
    public function indexAction()
    {
        return $this->render('EZCoreBundle:Layout:office/red/index.html.twig');
    }
}
