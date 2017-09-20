<?php

namespace OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('OrderBundle:header:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Zlecenia serwisowe',
        ]);
    }

    public function addAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('OrderBundle:header:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Nowe zlecenie serwisowe',
        ]);
    }
}