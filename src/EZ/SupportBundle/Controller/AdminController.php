<?php

namespace EZ\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends DataController
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $tickets = $em->getRepository('EZSupportBundle:Support')->findAll();
        return $this->render('@EZSupport/admin/list.html.twig', array(
            'tickets' => $tickets
        ));
    }
}
