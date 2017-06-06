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

    public function getArticleAction($id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('EZArticleBundle:Article')->find($id);

        return $article;
    }

    public function getCommentAction($id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('EZArticleBundle:Article')->find($id);
        $comments = $article->getComment();

        return $comments;
    }
}
