<?php

namespace WorkflowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkflowController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WorkflowBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'workflow',
            'navbar'        => 'Zarządzanie',
        ]);
    }
}