<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EZ\CoreBundle\Form\JsonapiType;
use Symfony\Component\Config\Definition\Exception\Exception;
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

            try
            {
                $api = $this->get('ez_core.jsonapi');
            }
            catch(Exception $e){
                die(var_dump($e));
                $this->get('session')->getFlashBag()->set('error', 'Erreur :'. $e->getMessage());
                return $this->redirect($this->generateUrl('ez_core_jsonapi'));
            }

            $api->setHost($new_jsonapi['jsonapi_ip']);
            $api->setPort($new_jsonapi['jsonapi_port']);
            $api->setUsername($new_jsonapi['jsonapi_username']);
            $api->setPassword($new_jsonapi['jsonapi_password']);

            $check_connection = $api->call("getServer");
            //die(var_dump($check_connection));
            if($check_connection[0]["is_success"] != TRUE && is_null($check_connection[0]["is_success"]) )
            {
                $this->get('session')->getFlashBag()->set('error', '<center>Connexion impossible !<br>Serveur éteint ou mauvais parametres</center>');
            }
            else
            {
                $value = Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/parameters.yml'));

                $value['parameters']['jsonapi']= $new_jsonapi;

                $yaml = YAML::dump($value);
                file_put_contents(__DIR__ . '/../Resources/config/parameters.yml', $yaml);
                $this->get('session')->getFlashBag()->set('success', 'Connexion avec le serveur effectuée avec succès !');
            }
            return $this->redirect($this->generateUrl('ez_core_jsonapi'));
        }
        $api = $this->get('ez_core.jsonapi');
        $server_data = $api->call("getServer")[0]["success"];

        return $this->render('EZCoreBundle:admin/pages:jsonapi.html.twig', array(
            'jsonapi' => $jsonapi_data,
            'server' => $server_data,
            'form' => $form->createView()));
    }


}
