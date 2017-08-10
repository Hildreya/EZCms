<?php

namespace EZ\SupportBundle\Controller;

use EZ\SupportBundle\Entity\Support;
use EZ\SupportBundle\Entity\Support_reponse;
use EZ\SupportBundle\Form\Support_reponseType;
use EZ\SupportBundle\Form\SupportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends Controller
{
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();

        $support = new Support();
        $support->setUserId($this->container->get('security.token_storage')->getToken()->getUser());

        $form = $this->createForm(SupportType::class, $support);

        $form->handleRequest($request);
        if ($form->isValid()) {
            //Cas report joueur
            if ($form->get('categorie')->getData() == 3) {
                if (!$form->get('Priority')->getData()) {
                    $session->getFlashBag()->add('error', 'Merci de compléter le pseudo d\'un joueur à report');
                    return $this->render('@EZSupport/default/home.html.twig', array(
                        'form' => $form->createView(),
                    ));
                } //On modifie l'entité pour la faire correspondre à la bdd
                else {
                    $support->setMessage("(Signalement de " . $support->getPriority() . ") " . $support->getMessage());
                    $support->setPriority(Support::MOYENNE);
                }
                //Pas de joueur report
            } elseif (!$form->get('priority')->getData()) {
                $session->getFlashBag()->add('error', 'Merci de définir une priorité');
                return $this->render('@EZSupport/default/home.html.twig', array(
                    'form' => $form->createView(),
                ));
            } else {
                $support->setPriority($form->get('priority')->getData());
            }

            $session->getFlashBag()->add('success', 'Le ticket à bien été validé');

            $em->persist($support);
            $em->flush();

            return $this->redirect($this->generateUrl('ez_support_list'));
        }

        return $this->render('@EZSupport/default/home.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function listAction($id = 0)
    {
        $repo = $this->getDoctrine()->getManager()->getRepository('EZSupportBundle:Support');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ($id) {
            $ticket = $repo->find($id);
            if (!$ticket) {
                throw new NotFoundHttpException('Ce ticket n\'éxiste pas !');
            }

            $reponse = new Support_reponse();
            $form = $this->createForm(Support_reponseType::class, $reponse);

            return $this->render('@EZSupport/default/detail.html.twig', array(
                'ticket' => $ticket,
                'list_reponse' => $ticket->getReponse(),
                'form' => $form->createView()
            ));
        }

        $list_ticket = $repo->getTicketsByUser($user);


        return $this->render('@EZSupport/default/list.html.twig', array(
            'list_ticket' => $list_ticket
        ));
    }


}
