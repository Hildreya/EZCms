<?php

namespace EZ\FAQBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class DataController extends Controller
{
    public function getQuestionsAction() {

        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository('EZFAQBundle:Faq')->findAll();

        return $questions;
    }

    public function getQuestionAction($id) {

        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository('EZFAQBundle:Faq')->find($id);

        return $question;
    }

    public function deleteQuestionAction($id){
        $em = $this->getDoctrine()->getManager();
        $question = $em->getRepository('EZFAQBundle:Faq')->find($id);

        if($question){
            $em->remove($question);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success', 'Suppression réussie !');
            return null;
        }
        else{
            $this->get('session')->getFlashBag()->set('error', 'Une erreur est survenue !');
            return null;
        }

    }
}
