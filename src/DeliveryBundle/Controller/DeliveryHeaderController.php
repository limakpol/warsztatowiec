<?php

namespace DeliveryBundle\Controller;

use CustomerBundle\Service\Helper\CustomerIndexHelper;
use DeliveryBundle\Service\Helper\DeliveryHeaderAddHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

class DeliveryHeaderController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('DeliveryBundle:header:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Przyjęcia towarów',
        ]);
    }

    public function addAction()
    {
        /** @var DeliveryHeaderAddHelper $headerAddHelper */
        $headerAddHelper = $this->get('delivery.helper.header_add');

        /** @var Form $form */
        $form = $headerAddHelper->createForm();

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        /** @var CustomerIndexHelper $customerIndexHelper */
        $customerIndexHelper = $this->get('customer.helper.index');

        $inputSortableParameters = $customerIndexHelper->getInputSortableParameters();
        $inputSortableParameters['limit'] = 15;
        $inputSortableParameters['systemFilters'] = ['supplier'];
        $outputSortableParameters = $customerIndexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $customers = $customerIndexHelper->retrieve($sortableParameters);

        return $this->render('DeliveryBundle:header:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Nowe przyjęcie towaru',
            'form'          => $form->createView(),
            'customers'     => $customers,
            'sortableParameters' => $sortableParameters,
        ]);
    }

    public function retrieveCustomersAction()
    {
        /** @var CustomerIndexHelper $customerIndexHelper */
        $customerIndexHelper = $this->get('customer.helper.index');

        $inputSortableParameters = $customerIndexHelper->getInputSortableParameters();
        $inputSortableParameters['limit'] = 15;
        $outputSortableParameters = $customerIndexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $customers = $customerIndexHelper->retrieve($sortableParameters);

        return $this->render('DeliveryBundle:header:customer_searchable_content.html.twig', [
            'customers' => $customers,
            'sortableParameters' => $sortableParameters,
        ]);
    }
}