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

            $template = $this->renderView('EZArticleBundle:admin:ajax.html.twig', array('user' => $user));

            $json = json_encode($template);
            $response = new Response($json, 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }else{
            throw new \Exception('Erreur');
        }

    }
}
