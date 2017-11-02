<?php

namespace EZ\UserBundle\Controller;

use EZ\UserBundle\Entity\Group;

use EZ\UserBundle\Form\GroupFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class GroupController extends Controller
{
    public function indexAction() {
        $groupManager = $this->get('fos_user.group_manager');
        $groups = $groupManager->findGroups();
        return $this->render('@EZUser/Group/list.html.twig', array(
            'groups' => $groups,
        ));
    }

    public function addAction(Request $request){
        $groupManager = $this->get('fos_user.group_manager');
        $newGroup = $groupManager->createGroup('');
        $groupForm = $this->createForm(GroupFormType::class, $newGroup);
        $groupForm->handleRequest($request);

        if($groupForm->isSubmitted() && $groupForm->isValid()){

            $em = $this->getDoctrine()->getManager();
            $em->persist($newGroup);
            $em->flush();

            return $this->redirectToRoute('ez_group_admin_list');
        }

        return $this->render('@EZUser/Group/new.html.twig', array(
            'groupForm' => $groupForm->createView(),
            'formErrors' => $groupForm->getErrors(),
        ));
    }

    public function editAction(Request $request, Group $groupId) {

        $editForm = $this->createForm(GroupFormType::class, $groupId);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupId);
            $em->flush();

            return $this->redirectToRoute('ez_group_admin_list');
        }

        return $this->render('@EZUser/Group/edit.html.twig', array(
            'group' => $groupId,
            'edit_form' => $editForm->createView(),
        ));
    }

    public function deleteAction(Group $group){
        $groupManager = $this->get('fos_user.group_manager');
        $groupManager->deleteGroup($group);

        return $this->redirectToRoute('ez_group_admin_list');
    }
}
