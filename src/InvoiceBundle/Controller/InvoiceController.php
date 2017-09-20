<?php

namespace InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvoiceController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('InvoiceBundle:invoice:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'invoice',
            'navbar'        => 'Faktury',
        ]);
    }

    public function addAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('InvoiceBundle:invoice:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'invoice',
            'navbar'        => 'Wystawianie nowej faktury',
        ]);
    }
}