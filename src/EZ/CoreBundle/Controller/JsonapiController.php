<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EZ\CoreBundle\Form\JsonapiType;
use Symfony\Component\Yaml\Yaml;


class JsonapiController extends Controller
{
    public function indexAction(Request $request)
    {

        $jsonapi_data = $this->getParameter('jsonapi');
        $form = $this->createForm(JsonapiType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $new_jsonapi = $form->getData();

            $value = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/parameters.yml'));

            $value['parameters']['jsonapi']= $new_jsonapi;

            $yaml = YAML::dump($value);
            file_put_contents(__DIR__ . '/../Resources/config/parameters.yml', $yaml);

            try
            {
                $api = $this->get('ez_core.jsonapi');
            }
            catch(Exception $e){
                die( 'Erreur :'. $e->getMessage());
            }

            if($api->call("getServer")[0]["is_success"] != NULL)
            {
                $this->get('session')->getFlashBag()->set('success', 'Connexion avec le serveur effectuée avec succès !');

            }
            else
            {
                $this->get('session')->getFlashBag()->set('error', 'Connexion impossible ! Le serveur est éteint ou les informations entrées ne sont pas valables');
            }
            return $this->redirect($this->generateUrl('ez_core_jsonapi'));
        }
        $api = $this->get('ez_core.jsonapi');
        $server_data = $api->call("getServer")[0]["success"];

        return $this->render('EZCoreBundle:Configuration:jsonapi.html.twig', array(
            'jsonapi' => $jsonapi_data,
            'server' => $server_data,
            'form' => $form->createView()));
    }


}
