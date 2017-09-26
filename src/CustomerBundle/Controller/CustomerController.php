<?php

namespace CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller
{

    public function indexAction()
    {

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Klienci',
        ]);
    }

    public function addAction()
    {

        $customerHelper = $this->get('customer.helper.customer');

        $form = $customerHelper->createAddForm();

        if($customerHelper->isValid($form))
        {
            $customerHelper->write($form);

            return $this->redirectToRoute('customer_index');
        }

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Dodawanie nowego klienta',
            'form'          => $form->createView(),
        ]);
    }

    public function editAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Klienci',
        ]);
    }

    public function removeAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Klienci',
        ]);
    }
}