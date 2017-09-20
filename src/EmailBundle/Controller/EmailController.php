<?php

namespace EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmailController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('EmailBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'email',
            'navbar'        => 'E-maile wysłane',
        ]);
    }

    public function sendAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('EmailBundle::send.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'sms',
            'navbar'        => 'Wyślij e-mail',
        ]);
    }
}