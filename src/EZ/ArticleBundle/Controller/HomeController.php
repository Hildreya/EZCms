<?php

namespace EZ\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

class HomeController extends Controller
{
    public function indexAction() {
        //Get the current template use
        $template = Yaml::parse(file_get_contents(__DIR__ . '/../../CoreBundle/Resources/config/parameters.yml'));
        $template = $template['parameters']['template'];

        //Get Articles
        $articles = $this->getArticlesAction();

        return $this->render('EZArticleBundle:office:home.html.twig', array(
            'selectedTemplate' => "EZCoreBundle:Layout/office:". $template .".html.twig",
            'articles' => $articles
        ));
    }

    public function selectAction($id) {
        //Get the current template use
        $template = Yaml::parse(file_get_contents(__DIR__ . '/../../CoreBundle/Resources/config/parameters.yml'));
        $template = $template['parameters']['template'];

        //Get Article
        $article = $this->getArticleAction($id);
        $comments = $article->getComment();

        return $this->render('EZArticleBundle:office:select.html.twig', array(
            'selectedTemplate' => "EZCoreBundle:Layout/office:". $template .".html.twig",
            'article' => $article,
            'comments' => $comments
        ));
    }

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
}
