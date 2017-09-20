<?php

namespace SmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SmsController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('SmsBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'sms',
            'navbar'        => 'SMS-y wysłane',
        ]);
    }

    public function sendAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('SmsBundle::send.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'sms',
            'navbar'        => 'Wyślij SMS',
        ]);
    }
}