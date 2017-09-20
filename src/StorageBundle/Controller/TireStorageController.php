<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 1:17 PM
 */

namespace StorageBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TireStorageController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('StorageBundle:tire:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'storage',
            'navbar'        => 'Przechowalnia opon',
        ]);
    }
}