<?php

namespace EZ\CoreBundle\Core;

use EZ\CoreBundle\JSONAPI\JSONAPI;
use Symfony\Component\Yaml\Yaml;

class Core
{
    private $jsonapi;

    public function __construct(JSONAPI $jsonapi){
        $this->jsonapi = $jsonapi;

    }

    public function online_players(){
        $result = $this->jsonapi->callMultiple(array('players.online.count', 'players.online.limit'), array(array(),array()));
        return $result[0]['is_success'] ? $result[0]['success'].' / '.$result[1]['success'] : 'Serveur OFF' ;
    }

    public function social_network(){

        return Yaml::parse(file_get_contents(__DIR__ . '/../Resources/config/parameters.yml'))['parameters']['icons'];


    }
}