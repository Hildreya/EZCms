<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EZ\CoreBundle\Form\LegalType;
use EZ\CoreBundle\Form\GeneralType;
use EZ\CoreBundle\Form\ReglementType;
use Symfony\Component\Yaml\Yaml;

class ConfigurationController extends Controller
{
    public function indexAction(Request $request){

        //Get current parameters
        $parameters = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/parameters.yml'));

        //Setting up legal form
        $legal = $this->getDoctrine()->getRepository('EZCoreBundle:Legal')->find(1);
        $legal_form = $this->createForm(LegalType::class, $legal);
        $legal_form->handleRequest($request);

        //Setting up general form
        $general_form = $this->createForm(GeneralType::class, $parameters);
        $general_form->handleRequest($request);

        //Setting up reglement form
        $reglement= $this->getDoctrine()->getRepository('EZCoreBundle:Reglement')->find(1);
        $reglement_form = $this->createForm(ReglementType::class, $reglement);
        $reglement_form->handleRequest($request);

        // legal_form treatment
        if($legal_form->isSubmitted() && $legal_form->isValid()){
            $this->getDoctrine()->getManager()->flush();
        }


        // general_form treatment
        if($general_form->isSubmitted() && $general_form->isValid()){

            //Get actual parameters array
            $form_data = $general_form->getData();

            //Change parameters array with new parameters from form
            $value = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/parameters.yml'));
            $value['parameters']['server_name'] = $form_data['server_name'];
            $value['parameters']['server_ip'] = $form_data['server_ip'];
            $value['parameters']['server_port'] = intval($form_data['server_port']);
            $value['parameters']['info_site_url'] = $form_data['info_site_url'];

            //Transform array into yaml, then set new parameters back in parameters.yml
            $yaml = YAML::dump($value);
            file_put_contents(__DIR__ . '/../Resources/config/parameters.yml', $yaml);

            //Moving logo/banner/favicon into web/img/
            $logo = $form_data['info_logo'];
            $banner = $form_data['info_banner'];
            $favicon = $form_data['info_favicon'];

            if ($logo != NULL )
            {
                if($logo->move(__DIR__.'/../../../../web/img/', 'logo.'.$logo->guessExtension())){
                    $this->get('session')->getFlashBag()->set('success', 'Changements enregistrés !');
                }else{
                    $this->get('session')->getFlashBag()->set('danger', 'Une erreur est survenue !');
                }
            }
            if ($favicon != NULL )
            {
                if($favicon->move(__DIR__.'/../../../../web/img/', 'favicon.'.$favicon->guessExtension())){
                    $this->get('session')->getFlashBag()->set('success', 'Changements enregistrés !');
                }else{
                    $this->get('session')->getFlashBag()->set('danger', 'Une erreur est survenue !');
                }
            }
            if ($banner != NULL )
            {
                if($banner->move(__DIR__.'/../../../../web/img/', 'banner.'.$banner->guessExtension())){
                    $this->get('session')->getFlashBag()->set('success', 'Changements enregistrés !');
                }else{
                    $this->get('session')->getFlashBag()->set('danger', 'Une erreur est survenue !');
                }
            }



        }

        // reglement_form treatment
        if($reglement_form->isSubmitted() && $reglement_form->isValid()){
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('EZCoreBundle:admin/pages:configuration.html.twig', array(
            'parameters' => $parameters['parameters'],
            'legal_form' => $legal_form->createView(),
            'general_form' => $general_form->createView(),
            'reglement_form' => $reglement_form->createView()
        ));
    }
}