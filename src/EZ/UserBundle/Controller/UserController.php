<?php

namespace EZ\UserBundle\Controller;

use EZ\UserBundle\Form\ChangePasswordType;
use EZ\UserBundle\Form\ProfileType;
use EZ\UserBundle\Form\RegistrationType;
use EZ\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

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

        $ajax_links = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/ajax-link.yml'));

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($userId);
            $em->flush();

            return $this->redirectToRoute('ez_user_admin_list');
        }

        return $this->render('@EZUser/admin/edit.html.twig', array(
            'ajax_links' => $ajax_links,
            'user' => $userId,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function addAction(Request $request) {
        $userManager = $this->get('fos_user.user_manager');
        $newUser = $userManager->createUser();
        $newUser->setEnabled(1);
        $registerForm = $this->createForm(RegistrationType::class, $newUser);

        $registerForm->handleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($newUser);
            $em->flush();

            return $this->redirectToRoute('ez_user_admin_list');
        }

        return $this->render('@EZUser/admin/add.html.twig',array(
            'registerForm'=> $registerForm->createView()
        ));
    }

    public function deleteAction(User $user){
        $userManager = $this->get('fos_user.user_manager');
        $userManager->deleteUser($user);

        return $this->redirectToRoute('ez_user_admin_list');
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
