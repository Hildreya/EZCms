<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('EZCoreBundle:admin/pages:dashbord.html.twig');
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

        return $this->render('EZCoreBundle:admin/Layout:module.html.twig', array(
            'bundles' => $bundles
        ));
    }
}
