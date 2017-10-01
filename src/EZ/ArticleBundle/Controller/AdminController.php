<?php

namespace EZ\ArticleBundle\Controller;

use EZ\ArticleBundle\Entity\Article;
use EZ\ArticleBundle\Form\ArticleType;
use EZ\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AdminController extends DataController
{
    public function listAction() {

        $articles = $this->getArticlesAction();

        return $this->render('EZArticleBundle:admin:list.html.twig', array(
            'articles' => $articles
        ));
    }

    public function createAction(Request $request) {

        $article = new Article();
        $article->setAuthor($this->getUser());

        $form = $this->createForm(ArticleType::class,$article);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirect($this->generateUrl('ez_article_admin_list'));
        }

        return $this->render('EZArticleBundle:admin:create.html.twig', array(
            'article_form' => $form->createView()
        ));
    }

    public function ajax_profileAction(Request $request, User $user){
        return $this->render('EZArticleBundle:admin:ajax.html.twig', array(
            'user' => $user
        ));
    }
}
