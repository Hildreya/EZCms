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
    //Admin interface

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
    public function editAction(Request $request, User $userId) {

        $editForm = $this->createForm(UserType::class, $userId);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userId);
            $em->flush();

            return $this->redirectToRoute('ez_user_admin_list');
        }

        return $this->render('@EZUser/admin/edit.html.twig', array(
            'user' => $userId,
            'edit_form' => $editForm->createView(),

        ));
    }

    public function deleteAction(User $user){
        $userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($user);

        return $this->redirectToRoute('ez_user_admin_list');
    }

    public function addAction() {
        $registerForm = $this->createForm(RegistrationType::class);


        return $this->render('@EZUser/admin/add.html.twig',array(
            'registerForm'=> $registerForm->createView()
        ));
    }

    /*User interface*/

    public function userEditAction(Request $request) {
        $userId = $this->getUser();

        $userEditForm = $this->createForm(ProfileType::class, $userId);
        $userEditForm->handleRequest($request);

        $form = $this->createForm(ChangePasswordType::class, $userId);
        $form->handleRequest($request);

        if ($userEditForm->isSubmitted() && $userEditForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userId);
            $em->flush();

            return $this->redirectToRoute('ez_user_edit');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $userManager = $this->get('fos_user.user_manager');
            $userManager->updateUser($userId);

            return $this->redirectToRoute('ez_user_edit');
        }

        return $this->render('@EZUser/Profile/show.html.twig', array(
            'user' => $userId,
            'edit_form' => $userEditForm->createView(),
            'form' => $form->createView()
        ));
    }
}
