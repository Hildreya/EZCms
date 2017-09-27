<?php

namespace EZ\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use EZ\CoreBundle\Entity\Jsonapi;
use EZ\CoreBundle\Form\JsonapiType;

use Symfony\Component\Yaml\Yaml;


class JsonapiController extends Controller
{

    public function indexAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('EZCoreBundle:Jsonapi');
        $jss = $repo->findAll();
        $order = array();
        for($pos = 0;$pos<=sizeof($jss); $pos++){
            array_push($order, $pos);
        }

        $new_jsonapi = new Jsonapi();
        $form = $this->createForm(JsonapiType::class, $new_jsonapi, array('position'=>$order));
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

        $api = $this->container->get('jsonapi');

        for($i = 0; $i< count($jsonapi_servers); $i++){
            $api->setHost($jsonapi_servers[$i]->getIp());
            $api->setPort($jsonapi_servers[$i]->getPort());
            $api->setUsername($jsonapi_servers[$i]->getUsername());
            $api->setPassword($jsonapi_servers[$i]->getPassword());

            $js = $jsonapi_servers[$i];
            $jsonapi_servers[$i] = null;
            $jsonapi_servers[$i]['jsonapi']= $js;
            $jsonapi_servers[$i]['info'] = $api->callMultiple(array('players.online.count', 'players.online.limit'), array(array(),array()));
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

    public function serverInfoAction(Request $request, $server_position)
    {
        if ($request->isXmlHttpRequest()) {

            $server = $this->getDoctrine()->getManager()->getRepository('EZCoreBundle:Jsonapi')
                ->findOneByPosition($server_position);
            $api = $this->container->get('jsonapi');
            $api->setHost($server->getIp());
            $api->setPort($server->getPort());
            $api->setUsername($server->getUsername());
            $api->setPassword($server->getPassword());

            $answer = $api->callMultiple(array('server', 'server.performance.disk.free', 'server.performance.disk.size', 'server.performance.memory.used', 'server.performance.memory.total'),
                array(
                    array(),
                    array(),
                    array(),
                    array(),
                    array()
                ));
            if ($answer[0]['is_success']) {
                $disk = ceil(100 - (($answer[1]['success'] / $answer[2]['success']) * 100));
                $memory = ceil(($answer[3]['success'] / $answer[4]['success']) * 100);
                $server = $answer[0]['success'];


                $response = new JsonResponse();
                return $response->setData(array(
                    'error' => false,
                    'memory' => $memory,
                    'disk' => $disk,
                    'server' => $server
                ));
            }else{
                $response = new JsonResponse();
                return $response->setData(array(
                    'error' => true
                ));

            }
        }else {
           throw new \Exception('Erreur');
        }
    }
}
