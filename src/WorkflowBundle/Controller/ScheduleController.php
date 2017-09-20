<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 1:42 PM
 */

namespace WorkflowBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ScheduleController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WorkflowBundle:schedule:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'workflow',
            'navbar'        => 'Terminarz',
        ]);
    }
}