<?php

namespace EZ\UserBundle\Controller;

use EZ\UserBundle\Form\ChangePasswordType;
use EZ\UserBundle\Form\ProfileType;
use EZ\UserBundle\Form\RegistrationType;
use EZ\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use EZ\UserBundle\Entity\User;

class UserController extends Controller
{

    /**
     * Lists all Users.
     *
     */
    public function indexAction() {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('@EZUser/admin/list.html.twig', array(
            'users' => $users,
        ));
    }

    /**
     * Displays a form to edit an existing Users.
     *
     */
    public function editAction(Request $request, User $id) {

        $editForm = $this->createForm(UserType::class, $id);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($id);
            $em->flush();

            return $this->redirectToRoute('ez_user_admin_list');
        }

        return $this->render('@EZUser/admin/edit.html.twig', array(
            'article' => $id,
            'edit_form' => $editForm->createView(),

        ));
    }

    public function addAction() {
        $registerForm = $this->createForm(RegistrationType::class);


        return $this->render('@EZUser/admin/add.html.twig',array(
            'registerForm'=> $registerForm->createView()
        ));
    }


        return $this->render('@EZUser/admin/add.html.twig',array(
            'registerForm'=> $registerForm->createView()
        ));
    }
}
