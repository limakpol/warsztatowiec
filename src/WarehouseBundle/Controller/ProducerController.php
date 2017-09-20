<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 2:27 AM
 */

namespace WarehouseBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProducerController extends Controller
{

    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WarehouseBundle:producer:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Producenci towarów',
        ]);
    }
}