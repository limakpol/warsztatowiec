<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/20/17
 * Time: 2:04 PM
 */

namespace OrderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderHeaderController extends Controller
{
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