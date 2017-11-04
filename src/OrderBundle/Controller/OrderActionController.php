<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/3/17
 * Time: 9:38 PM
 */

namespace OrderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderActionController extends Controller
{
    public function addAction($orderHeaderId, $orderIndexxId)
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('OrderBundle:action:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Dodawanie czynności do towaru w zleceniu',
        ]);
    }
}