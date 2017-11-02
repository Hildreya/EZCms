<?php

namespace EZ\SupportBundle\Controller;

use EZ\SupportBundle\Entity\S_Response;
use EZ\SupportBundle\Entity\Support;
use EZ\SupportBundle\Form\SupportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

                    return $this->render(
                        '@EZSupport/default/home.html.twig',
                        array(
                            'form' => $form->createView(),
                        )
                    );
                } //On modifie l'entité pour la faire correspondre à la bdd
                else {
                    $support->setMessage("(Signalement de ".$support->getPriority().") ".$support->getMessage());
                    $support->setPriority(Support::MOYENNE);
                }
                //Pas de joueur report
            } elseif (!$form->get('priority')->getData()) {
                $session->getFlashBag()->add('error', 'Merci de définir une priorité');

                return $this->render(
                    '@EZSupport/default/home.html.twig',
                    array(
                        'form' => $form->createView(),
                    )
                );
            } else {
                $support->setPriority($form->get('priority')->getData());
            }

            $session->getFlashBag()->add('success', 'Le ticket à bien été validé');

            $em->persist($support);
            $em->flush();

            return $this->redirect($this->generateUrl('ez_support_list'));
        }

        return $this->render(
            '@EZSupport/default/home.html.twig',
            array(
                'form' => $form->createView(),
            )
        );
    }

    public function listAction($id = 0)
    {
        $formUtils = $this->get('ez_support.form');
        $repo = $this->getDoctrine()->getManager()->getRepository('EZSupportBundle:Support');
        $user = $this->container->get('security.token_storage')->getToken()->getUser();

        if ($id) {
            $ticket = $repo->find($id);
            if (!$ticket) {
                throw new NotFoundHttpException('Ce ticket n\'éxiste pas !');
            }
            $response = new S_Response();

            $form = $formUtils->createFormResponse($response);

            return $this->render(
                '@EZSupport/default/detail.html.twig',
                array(
                    'ticket' => $ticket,
                    'list_reponse' => $ticket->getReponse(),
                    'form' => $form->createView(),
                )
            );
        }
        $list_ticket = $repo->getTicketsByUser($user);

        return $this->render(
            '@EZSupport/default/list.html.twig',
            array(
                'list_ticket' => $list_ticket,
            )
        );
    }

    public function newResponseAction(Request $request, $id)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('EZSupportBundle:Support');
        $ticket = $repo->find($id);
        if (!$ticket) {
            throw new NotFoundHttpException('Ce ticket n\'éxiste pas !');
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $formUtils = $this->get('ez_support.form');
        $response = new S_Response();
        $form = $formUtils->createFormResponse($response);

        if ($form->handleRequest($request)->isValid()) {
            $response->setUser($user);
            $response->setTicket($ticket);
            $ticket->addReponse($response);
            $em->persist($response);
            $em->flush();
            $session->getFlashBag()->add('success', 'Votre réponse à été ajoutée');
        }

        return $this->redirectToRoute(
            'ez_support_list',
            array(
                'id' => $ticket->getId(),
            )
        );
    }

    /**
     * Close ticket
     */
    public function closeAction($id, Request $request)
    {
        $session = $request->getSession();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('EZSupportBundle:Support');
        $ticket = $repo->find($id);
        if (!$ticket) {
            throw new NotFoundHttpException('Ce ticket n\'éxiste pas !');
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();

        if($ticket->getUserId() != $user)
        {
            throw new Exception('Ce ticket ne vous appartient pas');
        }

        if (!$ticket->getResolved()) {
            $ticket->close();
            $em->flush();
            $session->getFlashBag()->add('success', 'Le ticket à bien été fermé.');
        }
        else{
            throw new Exception('Ce ticket est déjà fermer');
        }

        return $this->redirectToRoute('ez_support_list', array(
            'id' => $id
        ));
    }
}
