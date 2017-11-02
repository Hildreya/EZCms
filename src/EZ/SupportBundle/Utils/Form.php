<?php

namespace EZ\SupportBundle\Utils;

use Doctrine\ORM\EntityManager;
use EZ\SupportBundle\Entity\S_Response;
use EZ\SupportBundle\Form\Support_reponseType;
use Symfony\Component\Form\FormFactory;

class Form
{
    private $em;
    private $formFactory;
    private $requestStack;
    private $router;

    public function __construct(EntityManager $em, FormFactory $formFactory,$requestStack, $router)
    {
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
        $this->router = $router;
    }

    public function createFormResponse(S_Response $response)
    {
        $form = $this->formFactory->create(
            Support_reponseType::class,
            $response,
            array(
                'action' => $this->router->generate('ez_support_response', array('id' => 1)),
            )
        );

        return $form;
    }
}