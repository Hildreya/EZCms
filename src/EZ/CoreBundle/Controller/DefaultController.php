<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('EZCoreBundle:Layout:admin/admin.html.twig');
    }

    public function BundleAction()
    {
        $directories = __DIR__.'/../../';
        $scanned_directory = array_diff(scandir($directories), array('..', '.'));

        foreach ($scanned_directory as $directory) {

            $bundles[$directory] = Yaml::parse(file_get_contents(__DIR__ . '/../../' . $directory . '/Resources/config/bundle.yml'));
        }
        return $this->render('EZCoreBundle:Default:module.html.twig', array(
            'bundles' => $bundles
        ));
    }
}
