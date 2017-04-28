<?php

namespace EZ\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class DataController extends Controller
{
    public function getArticlesAction() {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('EZArticleBundle:Article')->findAll();

        return $articles;
    }
}
