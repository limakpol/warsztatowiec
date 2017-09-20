<?php

namespace WarehouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WarehouseController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WarehouseBundle:good:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Towary',
        ]);
    }


}