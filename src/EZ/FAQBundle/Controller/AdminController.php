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
        $fAQ = new faq();
        $form = $this->createForm('EZ\FAQBundle\Form\FAQType', $fAQ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fAQ);
            $em->flush();

            return $this->redirectToRoute('faq_show', array('id' => $fAQ->getId()));
        }

        return $this->render('faq/new.html.twig', array(
            'fAQ' => $fAQ,
            'form' => $form->createView(),
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
    public function editAction(Request $request, Faq $fAQ)
    {
        die('coucou');
        $deleteForm = $this->createDeleteForm($fAQ);
        $editForm = $this->createForm('EZ\FAQBundle\Form\FAQType', $fAQ);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('faq_edit', array('id' => $fAQ->getId()));
        }

        return $this->render('faq/edit.html.twig', array(
            'fAQ' => $fAQ,
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
