<?php

namespace EZ\SupportBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class XhrController extends DataController
{
    public function getPlayersAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $pseudo = $request->get('term');
        $callback = $request->get('callback');

        $list_account = $this->searchPlayer($pseudo);

        $resultat = array();
        foreach ($list_account as $account) {

            array_push($resultat, array('name' => $account->getUsername()));
        }

        return new Response($callback . '(' . json_encode($resultat) . ')');    }
}
