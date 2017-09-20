<?php

namespace TrashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TrashController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('TrashBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'workflow',
            'navbar'        => 'Kosz',
        ]);
    }
}