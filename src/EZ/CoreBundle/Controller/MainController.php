<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

class MainController extends Controller
{
    public function indexAction()
    {
        $template = Yaml::parse(file_get_contents(__DIR__ . '/../../CoreBundle/Resources/config/parameters.yml'));
        $template = $template['template'];
        return $this->render('EZCoreBundle:Layout:office/' . $template . '/index.html.twig');
    }
}
