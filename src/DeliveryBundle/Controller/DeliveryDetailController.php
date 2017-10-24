<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/24/17
 * Time: 7:29 PM
 */

namespace DeliveryBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeliveryDetailController extends Controller
{

    public function addAction()
    {

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('DeliveryBundle:detail:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Dodawanie pozycji przyjęcia',
        ]);
    }
}