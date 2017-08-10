<?php

namespace EZ\ArticleBundle\Controller;

use EZ\ArticleBundle\Form\CommentType;
use EZ\ArticleBundle\Entity\Comment;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends DataController
{

    public function indexAction() {

        //Get Articles
        $articles = $this->getArticlesAction();

        return $this->render('EZArticleBundle:default:home.html.twig', array(
            'articles' => $articles
        ));
    }

    public function selectAction($id, Request $request) {

        //Get Article
        $article = $this->getArticleAction($id);
        $comments = $this->getCommentAction($id);

        $comment = new Comment();
        $comment->setAuthor($this->getUser());

        $form = $this->createForm(CommentType::class, $comment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $article->addComment($comment);
            $em->flush();
        }

        return $this->render('EZArticleBundle:default:select.html.twig', array(
            'article' => $article,
            'comments' => $comments,
            'comment_form' => $form->createView()
        ));
    }


}
