<?php

namespace EZ\FAQBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EZ\FAQBundle\Entity\Faq;

abstract class DataController extends Controller
{
    public function createQuestionAction(Faq $new_question){

        $em = $this->getDoctrine()->getManager();
        $em->persist($new_question);
        $em->flush();
    }

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
