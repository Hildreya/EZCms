<?php

namespace EZ\FAQBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class DataController extends Controller
{
    public function getQuestionsAction() {

        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository('FAQBundle:Faq')->findAll();

        return $questions;
    }
}
