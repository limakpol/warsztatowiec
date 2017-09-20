<?php

namespace StorageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StorageController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('StorageBundle:general:index.html.twig', [
            'headerMenu' => $headerMenu,
            'mainMenu' => $mainMenu,
            'tab' => 'storage',
            'navbar' => 'Przechowalnia ogólna',
        ]);
    }
}