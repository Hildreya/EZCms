<?php

namespace EZ\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends DataController
{
    public function indexAction()
    {
        return $this->render('@EZSupport/admin/list.html.twig');
    }
}
