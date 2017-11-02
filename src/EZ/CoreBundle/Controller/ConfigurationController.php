<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

use EZ\CoreBundle\Form\LegalType;
use EZ\CoreBundle\Form\GeneralType;
use EZ\CoreBundle\Form\SocialNetworkType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use EZ\CoreBundle\Form\ReglementType;


class ConfigurationController extends Controller
{
    public function indexAction(Request $request){

        //Get current parameters
        $parameters = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/parameters.yml'));
        $current_mail = $this->getParameter('mailer_user');
        $parameters['parameters']['email_contact'] = $current_mail;


        //Setting up legal form
        $legal = $this->getDoctrine()->getRepository('EZCoreBundle:Legal')->find(1);
        $legal_form = $this->createForm(LegalType::class, $legal);
        $legal_form->handleRequest($request);

        //Setting up general form
        $general_form = $this->createForm(GeneralType::class, null, array('parameters' => $parameters['parameters']));
        $general_form->handleRequest($request);

        //Setting up reglement form
        $reglement= $this->getDoctrine()->getRepository('EZCoreBundle:Reglement')->find(1);
        $reglement_form = $this->createForm(ReglementType::class, $reglement);
        $reglement_form->handleRequest($request);

        //Setting up social network form
        $sn_form = $this->createForm(SocialNetworkType::class, $parameters);
        foreach($parameters['parameters']['icons'] as $icon){
            $sn_form->add($icon['name'], TextType::class, array(
                'label' => $icon['name'],
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Entrez un URL',
                    'value' => $icon['link']
                )));
        }
        $sn_form->handleRequest($request);

        // social network treatment
        if($sn_form->isSubmitted() && $sn_form->isValid())
        {
            $sn_datas= $sn_form->getData();

            if($sn_datas['name'] && $sn_datas['icon'] && $sn_datas['link']){
                $parameters['parameters']['icons'][mb_strtolower($sn_datas['name'])]['name'] = $sn_datas['name'];
                $parameters['parameters']['icons'][mb_strtolower($sn_datas['name'])]['icon'] = $sn_datas['icon'];
                $parameters['parameters']['icons'][mb_strtolower($sn_datas['name'])]['link'] = $sn_datas['link'];

            }

            //Transform array into yaml, then set new parameters back in parameters.yml
            $yaml = YAML::dump($parameters);
            file_put_contents(__DIR__ . '/../Resources/config/parameters.yml', $yaml);
        }

        // legal_form treatment
        if($legal_form->isSubmitted() && $legal_form->isValid()){
            $this->getDoctrine()->getManager()->flush();

            return $this->redirect($this->generateUrl('ez_core_configuration'));
        }


        // general_form treatment
        if($general_form->isSubmitted() && $general_form->isValid()){

            //Get actual parameters array
            $form_data = $general_form->getData();

            //Change parameters array with new parameters from form
            $parameters['parameters']['server_name'] = $form_data['server_name'];
            $parameters['parameters']['server_ip'] = $form_data['server_ip'];
            $parameters['parameters']['server_port'] = intval($form_data['server_port']);
            $parameters['parameters']['info_site_url'] = $form_data['info_site_url'];
            $parameters['parameters']['presentation'] = $form_data['presentation'];

            //Transform array into yaml, then set new parameters back in parameters.yml
            $yaml = YAML::dump( $parameters);
            file_put_contents(__DIR__ . '/../Resources/config/parameters.yml', $yaml);

            if($form_data['email_contact'] != $current_mail){

            }

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


            return $this->redirect($this->generateUrl('ez_core_configuration'));
        }

        // reglement_form treatment
        if($reglement_form->isSubmitted() && $reglement_form->isValid()){
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($this->generateUrl('ez_core_configuration'));
        }


        return $this->render('EZCoreBundle:admin/pages:configuration.html.twig', array(
            'parameters' => $parameters['parameters'],
            'sn_form' => $sn_form->createView(),
            'legal_form' => $legal_form->createView(),
            'general_form' => $general_form->createView(),
            'reglement_form' => $reglement_form->createView()
        ));
    }

    public function reglement_ajaxformAction(Request $request){
        if($request->isXmlHttpRequest()) {

            //Setting up reglement form
            $reglement = $this->getDoctrine()->getRepository('EZCoreBundle:Reglement')->find(1);
            $reglement_form = $this->createForm(ReglementType::class, $reglement);
            $reglement_form->handleRequest($request);

            $template = $this->forward('EZCoreBundle:Configuration:template_generation', array('form' => $reglement, 'type' => 'reglement'))->getContent();

            $json = json_encode($template);
            $response = new Response($json, 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;

            // reglement treatment
            /*if($reglement_form->isSubmitted() && $reglement_form->isValid()){
                $this->getDoctrine()->getManager()->flush();
                return $this->redirect($this->generateUrl('ez_core_configuration'));
            }*/
        }

    }

    public function socialnetwork_ajaxformAction(Request $request){
        if($request->isXmlHttpRequest()) {

            //Get current parameters
            $parameters = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/parameters.yml'));

            //Setting up social network form
            $sn_form = $this->createForm(SocialNetworkType::class, $parameters);
            foreach ($parameters['parameters']['icons'] as $icon) {
                $sn_form->add($icon['name'], TextType::class, array(
                    'label' => $icon['name'],
                    'required' => false,
                    'attr' => array(
                        'placeholder' => 'Entrez un URL',
                        'value' => $icon['link']
                    )));
            }
            $sn_form->handleRequest($request);

            $template = $this->forward('EZCoreBundle:Configuration:template_generation', array('form' => $sn_form, 'type' => 'social_network'))->getContent();

            $json = json_encode($template);
            $response = new Response($json, 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;

            // social network treatment
            /*if ($sn_form->isSubmitted() && $sn_form->isValid()) {
                $sn_datas = $sn_form->getData();

                if ($sn_datas['name'] && $sn_datas['icon'] && $sn_datas['link']) {
                    $parameters['parameters']['icons'][mb_strtolower($sn_datas['name'])]['name'] = $sn_datas['name'];
                    $parameters['parameters']['icons'][mb_strtolower($sn_datas['name'])]['icon'] = $sn_datas['icon'];
                    $parameters['parameters']['icons'][mb_strtolower($sn_datas['name'])]['link'] = $sn_datas['link'];

                }

                //Transform array into yaml, then set new parameters back in parameters.yml
                $yaml = YAML::dump($parameters);
                file_put_contents(__DIR__ . '/../Resources/config/parameters.yml', $yaml);
            }*/
        }
    }

    public function legal_ajaxformAction(Request $request){
        if($request->isXmlHttpRequest()) {

            //Setting up legal form
            $legal = $this->getDoctrine()->getRepository('EZCoreBundle:Legal')->find(1);
            $legal_form = $this->createForm(LegalType::class, $legal);
            $legal_form->handleRequest($request);

            $template = $this->forward('EZCoreBundle:Configuration:template_generation', array('form' => $legal_form, 'type' => 'legal'))->getContent();

            $json = json_encode($template);
            $response = new Response($json, 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;

            // legal_form treatment
            /*if ($legal_form->isSubmitted() && $legal_form->isValid()) {
                $this->getDoctrine()->getManager()->flush();

                return $this->redirect($this->generateUrl('ez_core_configuration'));
            }*/
        }

    }

    public function template_generationAction($form, $type){

            return $this->render('EZCoreBundle:admin:pages:ajax_form:'. $type .'.html.twig', array('form' => $form->createView()));
        

    }

}
