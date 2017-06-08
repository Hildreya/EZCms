<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use EZ\CoreBundle\Entity\Jsonapi;
use EZ\CoreBundle\Form\JsonapiType;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Yaml\Yaml;


class JsonapiController extends Controller
{

    public function indexAction(Request $request)
    {
        /*
        $jss = $this->getDoctrine()->getManager()->getRepository('EZCoreBundle:Jsonapi')->findAll();
        $order = array('0' => 0);
        if(count($jss) > 1) {
            for ($i = 0; $i < count($jss)+1; $i++) {
                $order[$i] = $i;
            }
        }
         die(var_dump($order));
        */




        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('EZCoreBundle:Jsonapi');

        $new_jsonapi = new Jsonapi();
        $form = $this->createForm(JsonapiType::class, $new_jsonapi);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){


            $position = $form->getData()->getPosition();

            $query = $repo->createQueryBuilder('j')
                ->where('j.position >= :position')
                ->setParameter('position', $position)
                ->getQuery();
            $jsonapis = $query->getResult();

            for($i = 0; $i< count($jsonapis); $i++){
                $new_position = $jsonapis[$i]->getPosition() + 1;
                $jsonapis[$i]->setPosition($new_position);
                $em->persist($jsonapis[$i]);
            }

            $em->persist($form->getData());
            $em->flush();

            return $this->redirect($this->generateUrl('ez_core_jsonapi'));
        }

        $jsonapi_servers = $this->getDoctrine()->getRepository('EZCoreBundle:Jsonapi')
            ->findBy(array(), array('position' => 'ASC'));

        $api = $this->get('ez_core.jsonapi');

        for($i = 0; $i< count($jsonapi_servers); $i++){
            $api->setHost($jsonapi_servers[$i]->getIp());
            $api->setPort($jsonapi_servers[$i]->getPort());
            $api->setUsername($jsonapi_servers[$i]->getUsername());
            $api->setPassword($jsonapi_servers[$i]->getPassword());

            $js = $jsonapi_servers[$i];
            $jsonapi_servers[$i] = null;
            $jsonapi_servers[$i]['jsonapi']= $js;
            $jsonapi_servers[$i]['server'] = $api;
            $jsonapi_servers[$i]['status'] = $api->call("server")[0]['success'];
            $jsonapi_servers[$i]['player_connected'] = $api->call("players.online.count")[0]['success'];
        }

        //die(var_dump($jsonapi_servers));


        return $this->render('EZCoreBundle:admin/pages:jsonapi.html.twig', array(
            'jsonapi_servers' => $jsonapi_servers,
            'form' => $form->createView()));
    }
    public function deleteAction($id){

        if($jsonapi_server = $this->getDoctrine()->getRepository('EZCoreBundle:Jsonapi')
            ->findOneById($id)) {


            $position = $jsonapi_server->getPosition();

            $em = $this->getDoctrine()->getManager();
            $em->remove($jsonapi_server);
            $query = $em->getRepository('EZCoreBundle:Jsonapi')->createQueryBuilder('j')
                ->where('j.position > :position')
                ->setParameter('position', $position)
                ->getQuery();
            $jsonapis = $query->getResult();

            for($i = 0; $i< count($jsonapis); $i++){
                $new_position = $jsonapis[$i]->getPosition() -1 ;
                $jsonapis[$i]->setPosition($new_position);
                $em->persist($jsonapis[$i]);
            }

            $em->flush();

            $this->get('session')->getFlashBag()->set('success', 'Suppression réussie !');
        }
        else{
            $this->get('session')->getFlashBag()->set('warning', 'Une erreur est survenue !');
        }

        return $this->redirect($this->generateUrl('ez_core_jsonapi'));

    }


}
