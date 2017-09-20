<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 1:16 PM
 */

namespace StorageBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PlaceController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('StorageBundle:place:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'storage',
            'navbar'        => 'Miejsca przechowywania',
        ]);
    }
}