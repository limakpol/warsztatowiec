<?php

namespace ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServiceController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('ServiceBundle:service:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'service',
            'navbar'        => 'Usługi',
        ]);
    }
}