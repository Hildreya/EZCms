<?php

namespace EZ\FAQBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use EZ\FAQBundle\Controller\DataController;

class DefaultController extends DataController
{
    public function indexAction()
    {
        $questions = $this->getQuestionsAction();

        return $this->render('FAQBundle:default:index.html.twig', array(
            'questions' => $questions
        ));
    }
}
