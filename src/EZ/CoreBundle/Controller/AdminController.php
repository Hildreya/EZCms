<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

class AdminController extends Controller
{
    public function indexAction()
    {
        return $this->render('EZCoreBundle:Layout:admin/pages/dashbord.html.twig');
    }

    public function bundleAction()
    {
        //Get all the bundles present on the cms
        $bundles = array();
        $directories = __DIR__.'/../../';
        $scanned_directory = array_diff(scandir($directories), array('..', '.'));

        foreach ($scanned_directory as $directory) {

            $bundles[$directory] = Yaml::parse(file_get_contents(__DIR__ . '/../../' . $directory . '/Resources/config/bundle.yml'));
        }

        return $this->render('EZCoreBundle:Layout/admin:module.html.twig', array(
            'bundles' => $bundles
        ));
    }
}
