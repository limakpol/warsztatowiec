<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 2:32 AM
 */

namespace WorkflowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkmanController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WorkflowBundle:workman:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'workflow',
            'navbar'        => 'Pracownicy',
        ]);
    }

    public function addAction()
    {
        $workmanAddHelper = $this->get('workflow.helper.workman_add');

        $form = $workmanAddHelper->createAddForm();

        if($workmanAddHelper->isValid($form))
        {
                $workmanAddHelper->write($form);

                return $this->redirectToRoute('workflow_workman_index');
        }

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WorkflowBundle:workman:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'workflow',
            'navbar'        => 'Dodawanie nowego pracownika',
            'form'          => $form->createView(),
        ]);
    }
}