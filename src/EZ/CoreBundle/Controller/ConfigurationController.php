<?php

namespace EZ\CoreBundle\Controller;

use EZ\CoreBundle\EZCoreBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Yaml;

use EZ\CoreBundle\Form\LegalType;
use EZ\CoreBundle\Form\GeneralType;
use EZ\CoreBundle\Form\ReglementType;
use EZ\CoreBundle\Form\SocialNetworkType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use EZ\CoreBundle\Entity\Reglement;
use EZ\CoreBundle\Entity\Legal;


class ConfigurationController extends Controller
{
    public function indexAction(Request $request){

        $path = $this->get('kernel')->getRootDir();

        //Get current parameters
        $parameters = Yaml::parse(file_get_contents($path.'/config/parameters.yml'));

        //Setting up general form
        $general_form = $this->createForm(GeneralType::class, null, array('parameters' => $parameters['parameters']));
        $general_form->handleRequest($request);


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
            $parameters['parameters']['mailer_user'] = $form_data["mailer_user"];

            //Transform array into yaml, then set new parameters back in parameters.yml
            $yaml = YAML::dump( $parameters);
            file_put_contents($path.'/config/parameters.yml', $yaml);

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


        return $this->render('EZCoreBundle:admin/pages:configuration.html.twig', array(
            'parameters' => $parameters['parameters'],
            'general_form' => $general_form->createView(),
        ));
    }

    public function reglement_ajaxformAction(Request $request){

        $reglement = $this->getDoctrine()->getRepository('EZCoreBundle:Reglement')->find(1);
        if (!$reglement){
            $reglement = new Reglement();
        }
        $reglement_form = $this->createForm(ReglementType::class, $reglement);
        $reglement_form->handleRequest($request);

        if($request->isXmlHttpRequest()) {

            $template = $this->renderView('EZCoreBundle:admin:pages/ajax/reglement_form.html.twig', array('form' => $reglement_form->createView()));

            $json = json_encode($template);
            $response = new Response($json, 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        //Form send
        elseif($reglement_form->isSubmitted() && $reglement_form->isValid()){

            $em =  $this->getDoctrine()->getManager();
            $em->persist($reglement);
            $em->flush();

            return $this->redirect($this->generateUrl('ez_core_configuration'));

        }
        else{
            throw new \Exception('Something went wrong!');
        }

    }

    public function socialnetwork_ajaxformAction(Request $request){

        $parameters = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/parameters.yml'));

        $add_form = $this->createForm(SocialNetworkType::class, null, array('asset' => $this->get('assets.packages')));
        $add_form->handleRequest($request);

        $form = $this->createFormBuilder();
        foreach ($parameters['parameters']['icons'] as $icon) {
            $form->add($icon['name'], TextType::class, array(
                'label' => $icon['name'],
                'required' => false,
                'attr' => array(
                    'placeholder' => 'Entrez un URL',
                    'value' => $icon['link']
                )));
        }
        $form->add('Enregistrer', SubmitType::class, array(
            'attr' => array(
                'class' => 'button-green'
            )));
        $edit_form = $form->getForm();
        $edit_form->handleRequest($request);




        if($request->isXmlHttpRequest()) {
            $template = $this->renderView('EZCoreBundle:admin:pages/ajax/social_network.html.twig', array('edit_form' => $edit_form->createView(), 'add_form' => $add_form->createView()));

            $json = json_encode($template);
            $response = new Response($json, 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        elseif($edit_form->isSubmitted() && $edit_form->isValid()) {
            $form_data = $edit_form->getData();
            die(var_dump($form_data));
            return $this->redirect($this->generateUrl('ez_core_configuration'));
        }
        elseif($add_form->isSubmitted() && $add_form->isValid()){
            $form_data = $add_form->getData();
            die(var_dump($form_data));
            return $this->redirect($this->generateUrl('ez_core_configuration'));
        }
        else{
            throw new \Exception('Something went wrong!');
        }


    }

    public function legal_ajaxformAction(Request $request){
        //Setting up legal form
        $legal = $this->getDoctrine()->getRepository('EZCoreBundle:Legal')->find(1);
        if(!$legal){
            $legal = new Legal();
        }
        $legal_form = $this->createForm(LegalType::class, $legal);
        $legal_form->handleRequest($request);

        if($request->isXmlHttpRequest()) {

            $template = $this->renderView('EZCoreBundle:admin:pages/ajax/legal.html.twig', array('form' => $legal_form->createView()));

            $json = json_encode($template);
            $response = new Response($json, 200);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
        elseif($legal_form->isSubmitted() && $legal_form->isValid()){

            $em =  $this->getDoctrine()->getManager();
            $em->persist($legal);
            $em->flush();

            return $this->redirect($this->generateUrl('ez_core_configuration'));

        }
        else{
            throw new \Exception('Something went wrong!');
        }

    }


}
