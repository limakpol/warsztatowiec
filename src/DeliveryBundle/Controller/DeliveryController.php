<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/17/17
 * Time: 4:39 PM
 */

namespace DeliveryBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends Controller
{

    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('DeliveryBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Przyjęcia towarów',
        ]);
    }

    public function showAction($deliveryHeaderId)
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('DeliveryBundle::show.html.twig', [
            'deliveryHeaderId' => $deliveryHeaderId,
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Przyjęcie towaru',
        ]);
    }

    public function removeAction()
    {
        return new Response();
    }
}