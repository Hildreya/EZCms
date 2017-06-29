<?php

namespace EZ\FAQBundle\Controller;

use EZ\FAQBundle\Entity\faq;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EZ\FAQBundle\Controller\DataController;

/**
 * Faq controller.
 *
 */
class AdminController extends DataController
{
    /**
     * Lists all fAQ entities.
     *
     */
    public function indexAction()
    {
        $faq = $this->getQuestionsAction();

        return $this->render('EZFAQBundle:admin:index.html.twig', array(
            'faq' => $faq,
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
    public function showAction(faq $fAQ)
    {
        $deleteForm = $this->createDeleteForm($fAQ);

        return $this->render('faq/show.html.twig', array(
            'fAQ' => $fAQ,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fAQ entity.
     *
     */
    public function editAction(Request $request, faq $fAQ)
    {
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

    public function deleteAction($id)
    {
        if($this->deleteQuestionAction($id)){
            $this->get('session')->getFlashBag()->set('success', 'Suppression réussie !');
        }else{
            $this->get('session')->getFlashBag()->set('error', 'Une erreur est survenue !');
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
            ->setAction($this->generateUrl('faq_delete', array('id' => $fAQ->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
