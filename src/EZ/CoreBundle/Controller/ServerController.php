<?php
namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class ServerController extends Controller
{
    public function indexAction(){

        return $this->render('EZCoreBundle:admin/pages:server.html.twig');
    }

}