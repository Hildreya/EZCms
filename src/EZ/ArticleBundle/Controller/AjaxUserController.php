<?php

namespace EZ\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use EZ\UserBundle\Entity\User;


class AjaxUserController extends Controller
{
    public function ajax_profileAction(Request $request, User $user){
        if ($request->isXmlHttpRequest()) {
            $template = $this->forward('EZArticleBundle:AjaxUser:template', array('user' => $user))->getContent();

            $json = json_encode($template);
            $response = new Response($json, 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            throw new \Exception('Erreur');
        }

    }
    public function templateAction(User $user){
        return $this->render('EZArticleBundle:admin:ajax.html.twig', array('user' => $user));

    }
}
