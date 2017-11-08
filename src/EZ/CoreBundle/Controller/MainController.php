<?php

namespace EZ\CoreBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

class MainController extends Controller
{
    public function indexAction()
    {
        $template = $this->getParameter('template');
        //Get users
        $users = $this->getUsersAction();

        return $this->render('EZCoreBundle:default/Layout/' . $template . ':index.html.twig', array(
            'users' => $users
        ));
    }
    public function bundleAction()
    {
        $rootdir = $this->get('kernel')->getRootDir();

        //Get all the bundles present on the cms
        $bundles = array();
        $directories = $rootdir.'/../src/EZ';
        $scanned_directory = array_diff(scandir($directories), array('..', '.'));

        foreach ($scanned_directory as $directory) {

            $bundles[$directory] = Yaml::parse(file_get_contents($rootdir . '/../src/EZ/' . $directory . '/Resources/config/bundle.yml'));
        }

        return $this->render('EZCoreBundle:default/Layout:module.html.twig', array(
            'bundles' => $bundles
        ));
    }

    public function getUsersAction() {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        $nbUsers = count($users);

        return $nbUsers;
    }
}
