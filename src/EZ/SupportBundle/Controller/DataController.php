<?php

namespace EZ\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

abstract class DataController extends Controller
{
    public function searchPlayer($pseudo)
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->getRepository('EZUserBundle:User')->createQueryBuilder('u')
            ->where('UPPER(u.username) LIKE UPPER(:pseudo)')
            ->setParameter(':pseudo', $pseudo . '%');

        return $query->getQuery()->getResult();
    }
}
