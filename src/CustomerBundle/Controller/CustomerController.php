<?php

namespace CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends Controller
{

    public function indexAction()
    {
        $indexHelper = $this->get('customer.helper.index');

        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $customers  = $indexHelper->retrieve($sortableParameters);
        $groupps    = $indexHelper->retrieveGroupps();
        $limitSet   = $this->getParameter('app')['limit_set'];

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Klienci',
            'customers'     => $customers,
            'groupps'       => $groupps,
            'limitSet'      => $limitSet,
            'sortableParameters' => $sortableParameters,
        ]);
    }

    public function retrieveAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        if(!$request->isMethod('POST') || !$request->isXmlHttpRequest())
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => ['Nieprawidłowe żądanie'],
            ]);
        }

        $indexHelper = $this->get('customer.helper.index');
        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $customers  = $indexHelper->retrieve($sortableParameters);

        $groupps    = $indexHelper->retrieveGroupps();
        $limitSet   = $this->getParameter('app')['limit_set'];

        return $this->render('CustomerBundle::sortable_content.html.twig', [
            'customers' => $customers,
            'groupps' => $groupps,
            'limitSet' => $limitSet,
            'sortableParameters' => $sortableParameters,
        ]);
    }

    public function showAction($customerId)
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::show.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Klient',
        ]);
    }

    public function addAction()
    {

        $customerHelper = $this->get('customer.helper.add');

        $form = $customerHelper->createAddForm();

        if($customerHelper->isValid($form))
        {
            $customerHelper->write($form);

            return $this->redirectToRoute('customer_index');
        }

        $groupps = $customerHelper->retrieveGroupps();

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Dodawanie nowego klienta',
            'form'          => $form->createView(),
            'groupps'       => $groupps,
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