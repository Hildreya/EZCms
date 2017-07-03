<?php

namespace EZ\FAQBundle\Controller;

use EZ\FAQBundle\Entity\Faq;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EZ\FAQBundle\Controller\DataController;

/**
 * Admin controller.
 *
 */
class AdminController extends DataController
{
    /**
     * Lists all fAQ entities.
     *
     */
    public function indexAction(Request $request)
    {
        $questions = $this->getQuestionsAction();

        $question = new faq();
        $form = $this->createForm('EZ\FAQBundle\Form\FAQType', $question);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($question);
            $em->flush();

            return $this->redirectToRoute('ez_faq_admin_list');
        }


        return $this->render('EZFAQBundle:admin:index.html.twig', array(
            'form_new' => $form->createView(),
            'questions' => $questions,
        ));
    }

    /**
     * Creates a new fAQ entity.
     *
     */
    public function newAction(Request $request)
    {
        $new_question = new Faq();
        $form_new = $this->createForm('EZ\FAQBundle\Form\FAQType', $new_question);
        $form_new->handleRequest($request);

        if ($form_new->isSubmitted() && $form_new->isValid()) {

            $this->createQuestionAction($new_question);

            return $this->redirectToRoute('ez_faq_admin_show', array('id' => $new_question->getId()));
        }

        return $this->render('EZFAQBundle:admin:new.html.twig', array(
            'new_question' => $new_question,
            'form_new' => $form_new->createView(),
        ));
    }

    /**
     * Finds and displays a fAQ entity.
     *
     */
    public function showAction(Faq $question)
    {

        $deleteForm = $this->createDeleteForm($question);

        return $this->render('EZFAQBundle:admin:show.html.twig', array(
            'question' => $question,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fAQ entity.
     *
     */
    public function editAction(Request $request, Faq $question)
    {
        $deleteForm = $this->createDeleteForm($question);
        $editForm = $this->createForm('EZ\FAQBundle\Form\FAQType', $question);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('faq_edit', array('id' => $question->getId()));
        }

        return $this->render('EZFAQBundle:admin:edit.html.twig', array(
            'question' => $question,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction(request $request, Faq $faq)
    {
        $form = $this->createDeleteForm($faq);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->deleteQuestionAction($faq);
        }

        return $this->redirectToRoute('ez_faq_admin_list');
    }

    /**
     * Creates a form to delete a fAQ entity.
     *
     * @param faq $fAQ The fAQ entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(faq $fAQ)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ez_faq_admin_delete', array('id' => $fAQ->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
