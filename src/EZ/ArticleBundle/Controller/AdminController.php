<?php

namespace EZ\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends DataController
{
    public function listAction() {

        $articles = $this->getArticlesAction();

        return $this->render('EZArticleBundle:admin:list.html.twig', array(
            'articles' => $articles
        ));
    }
}
