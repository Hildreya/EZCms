<?php

namespace EZ\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EZArticleBundle:Default:index.html.twig');
    }
}
