<?php

namespace SaleBundle\Controller;

use CustomerBundle\Service\Helper\CustomerIndexHelper;
use SaleBundle\Service\Helper\SaleHeaderAddHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;

class SaleHeaderController extends Controller
{

    public function addAction()
    {

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        /** @var CustomerIndexHelper $customerIndexHelper */
        $customerIndexHelper = $this->get('customer.helper.index');

        /** @var SaleHeaderAddHelper $headerAddHelper */
        $headerAddHelper = $this->get('sale.helper.header_add');

        /** @var Form $form */
        $form = $headerAddHelper->createForm();

        if($headerAddHelper->isValid($form))
        {
            $saleHeaderId = $headerAddHelper->write($form);

            return $this->redirectToRoute('sale_show', [
                'saleHeaderId' => $saleHeaderId,
            ]);
        }

        $sortableParameters = $headerAddHelper->getSortableParameters();

        $customers  = $customerIndexHelper->retrieve($sortableParameters);
        $groupps    = $customerIndexHelper->retrieveGroupps();

        return $this->render('SaleBundle:header:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Nowe wystawienie towaru',
            'form'          => $form->createView(),
            'customers'     => $customers,
            'groupps'       => $groupps,
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

        return $this->render('SaleBundle:header:customer_searchable_content.html.twig', [
            'customers' => $customers,
            'sortableParameters' => $sortableParameters,
        ]);
    }

    public function getNextDocumentNumberAction()
    {
        /** @var SaleHeaderAddHelper $headerAddHelper */
        $headerAddHelper = $this->get('sale.helper.header_add');

        return $headerAddHelper->getNextDocumentNumber();
    }

}