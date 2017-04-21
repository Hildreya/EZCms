<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Request;
use EZ\CoreBundle\Form\TemplateType;
use ZipArchive;

class TemplateController extends Controller
{
    public function templateAction(Request $request){

        $template_used = Yaml::parse(file_get_contents(__DIR__ . '/../../CoreBundle/Resources/config/parameters.yml'));
        $template_used = $template_used['template'];

        $templates_dir = __DIR__.'/../Resources/views/layout/office';
        $templates_dir = array_diff(scandir($templates_dir), array('..', '.'));

        foreach ($templates_dir as $template){
            if(preg_match('#.html.twig$#',$template)){
                $template =str_replace('.html.twig', '', $template);
                $templates[$template] = $template;
            }
        }
        $form = $this->createForm(TemplateType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $task = $form->getData();

            $file = $task['theme'];
            if( $file->getClientOriginalExtension() === 'zip')
            {

                $file_name = $file->getClientOriginalName();
                $file->move(__DIR__.'/../Resources/views/Layout/office',$file_name);

                $zip = new ZipArchive();
                if($zip->open(__DIR__.'/../Resources/views/Layout/office/'.$file_name) === TRUE )
                {
                    $zip->extractTo( __DIR__.'/../Resources/views/Layout/office');
                    $zip->close();
                    unlink(__DIR__.'/../Resources/views/Layout/office/'.$file_name);

                    if(is_dir(__DIR__.'/../../../../web/img/template'))
                    {
                        $template_img = str_replace('.zip', '.png', $file_name);
                        rename(__DIR__.'/../Resources/views/Layout/office/'.$template_img ,__DIR__.'/../../../../web/img/template/'.$template_img);
                    }
                    else
                    {
                        mkdir(__DIR__.'/../../../../web/img/template');
                        $template_img = str_replace('.zip', '.png', $file_name);
                        rename(__DIR__.'/../Resources/views/Layout/office/'.$template_img,__DIR__.'/../../../../web/img/template/'.$template_img);

                    }

                    $this->get('session')->getFlashBag()->set('success', 'Theme telecharge avec succes !');
                }

                return $this->redirect($this->generateUrl('ez_core_template'));
            }
            else
            {
                die('It must be a zip file');
            }



        }

        return $this->render('EZCoreBundle:template:index.html.twig', array(
            'template_used' => $template_used,
            'templates' => $templates,
            'form' => $form->createView()
        ));
    }

    public function SelectAction($name){

        $parameters = Yaml::parse(file_get_contents(__DIR__ . '/../../CoreBundle/Resources/config/parameters.yml'));
        $parameters['template'] = $name;
        $parameters_yml = Yaml::dump($parameters);

        file_put_contents(__DIR__ . '/../../CoreBundle/Resources/config/parameters.yml', $parameters_yml);

        $this->get('session')->getFlashBag()->set('success', 'Theme actuel modifie pourr le theme : '. $name.' !');

        return $this->redirect($this->generateUrl('ez_core_template'));
    }
}