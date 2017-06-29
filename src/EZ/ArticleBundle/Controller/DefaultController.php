<?php

namespace EZ\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;
use EZ\ArticleBundle\Controller\DataController;

class DefaultController extends DataController
{

    public function indexAction() {

        //Get Articles
        $articles = $this->getArticlesAction();

        return $this->render('EZArticleBundle:default:home.html.twig', array(
            'articles' => $articles
        ));
    }

    public function selectAction($id) {

        //Get Article
        $article = $this->getArticleAction($id);
        $comments = $this->getCommentAction($id);

        return $this->render('EZArticleBundle:default:select.html.twig', array(
            'article' => $article,
            'comments' => $comments
        ));
    }
}
