<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use EZ\CoreBundle\Form\TemplateType;
use ZipArchive;

class TemplateController extends Controller
{
    public function templateAction(Request $request){

        $template_used = $this->getParameter('template');

        $templates_dir = __DIR__.'/../Resources/views/office/Layout';
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
                $file->move(__DIR__.'/../Resources/views/office/Layout',$file_name);

                $zip = new ZipArchive();
                if($zip->open(__DIR__.'/../Resources/views/office/Layout/'.$file_name) === TRUE )
                {
                    $zip->extractTo( __DIR__.'/../Resources/views/office/Layout');
                    $zip->close();
                    unlink(__DIR__.'/../Resources/views/office/Layout/'.$file_name);

                    if(is_dir(__DIR__.'/../../../../web/img/template'))
                    {
                        $template_img = str_replace('.zip', '.png', $file_name);
                        rename(__DIR__.'/../Resources/views/office/Layout/'.$template_img ,__DIR__.'/../../../../web/img/template/'.$template_img);
                    }
                    else
                    {
                        mkdir(__DIR__.'/../../../../web/img/template');
                        $template_img = str_replace('.zip', '.png', $file_name);
                        rename(__DIR__.'/../Resources/views/office/Layout/'.$template_img,__DIR__.'/../../../../web/img/template/'.$template_img);

                    }

                    $this->get('session')->getFlashBag()->set('success', 'Theme telecharge avec succes !');
                }

                return $this->redirect($this->generateUrl('ez_core_template'));
            }
            else
            {
                $this->get('session')->getFlashBag()->set('error', 'Le fichier doit être un zip !');
                return $this->redirect($this->generateUrl('ez_core_template'));
            }



        }

        return $this->render('EZCoreBundle:admin/pages:template.html.twig', array(
            'template_used' => $template_used,
            'templates' => $templates,
            'form' => $form->createView()
        ));
    }

    public function SelectAction($name){

        $value = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/parameters.yml'));

        $value['parameters']['template'] = $name;

        $yaml = YAML::dump($value);
        file_put_contents(__DIR__ . '/../Resources/config/parameters.yml', $yaml);

        $this->get('session')->getFlashBag()->set('success', 'Theme actuel modifie pourr le theme : '. $name.' !');

        return $this->redirect($this->generateUrl('ez_core_template'));
    }
}