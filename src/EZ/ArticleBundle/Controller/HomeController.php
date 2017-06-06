<?php

namespace EZ\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;
use EZ\ArticleBundle\Controller\DataController;

class HomeController extends DataController
{

    public function indexAction() {

        //Get the current template use
        $template = Yaml::parse(file_get_contents(__DIR__ . '/../../CoreBundle/Resources/config/parameters.yml'));
        $template = $template['parameters']['template'];

        //Get Articles
        $articles = $this->getArticlesAction();

        return $this->render('EZArticleBundle:office:home.html.twig', array(
            'selectedTemplate' => "EZCoreBundle:office/Layout:". $template .".html.twig",
            'articles' => $articles
        ));
    }

    public function selectAction($id) {

        //Get the current template use
        $template = Yaml::parse(file_get_contents(__DIR__ . '/../../CoreBundle/Resources/config/parameters.yml'));
        $template = $template['parameters']['template'];

        //Get Article
        $article = $this->getArticleAction($id);
        $comments = $this->getCommentAction($id);

        return $this->render('EZArticleBundle:office:select.html.twig', array(
            'selectedTemplate' => "EZCoreBundle:office/Layout:". $template .".html.twig",
            'article' => $article,
            'comments' => $comments
        ));
    }
}
