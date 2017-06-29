<?php

namespace EZ\ArticleBundle\Controller;

use EZ\ArticleBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends DataController
{
    public function listAction() {

        $articles = $this->getArticlesAction();

        return $this->render('EZArticleBundle:admin:list.html.twig', array(
            'articles' => $articles
        ));
    }

    public function createAction(Request $request) {
        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('ez_article_admin_list'));
        }

        return $this->render('EZArticleBundle:admin:create.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
