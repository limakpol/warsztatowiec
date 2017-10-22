<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/20/17
 * Time: 2:04 PM
 */

namespace OrderBundle\Controller;


use CustomerBundle\Service\Helper\CustomerIndexHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use VehicleBundle\Service\Helper\VehicleIndexHelper;

class OrderHeaderController extends Controller
{
    public function addAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        $orderHeaderAddHelper   = $this->get('order.helper.header_add');

        $form = $orderHeaderAddHelper->createForm();

        if($orderHeaderAddHelper->isValid($form))
        {
            $orderHeaderId = $orderHeaderAddHelper->write($form);

            return $this->redirectToRoute('order_show', [
                'orderHeaderId' => $orderHeaderId,
            ]);
        }

        $customerIndexHelper    = $this->get('customer.helper.index');
        $vehicleIndexHelper     = $this->get('vehicle.helper.index');

        $customerSortableParameters = $orderHeaderAddHelper->getCustomerSortableParameters();
        $vehicleSortableParameters = $orderHeaderAddHelper->getVehicleSortableParameters();

        $customers = $customerIndexHelper->retrieve($customerSortableParameters);
        $groupps = $customerIndexHelper->retrieveGroupps();
        $vehicles = $vehicleIndexHelper->retrieve($vehicleSortableParameters);

        return $this->render('OrderBundle:header:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Nowe zlecenie serwisowe',
            'form'          => $form->createView(),
            'customers'     => $customers,
            'vehicles'      => $vehicles,
            'groupps'       => $groupps,
            'customerSortableParameters' => $customerSortableParameters,
            'vehicleSortableParameters' => $vehicleSortableParameters,
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

        return $this->render('OrderBundle:header:customer_searchable_content.html.twig', [
            'customers' => $customers,
            'customerSortableParameters' => $sortableParameters,
        ]);
    }

    public function retrieveVehiclesAction()
    {
        /** @var VehicleIndexHelper $vehicleIndexHelper */
        $vehicleIndexHelper = $this->get('vehicle.helper.index');

        $inputSortableParameters = $vehicleIndexHelper->getInputSortableParameters();
        $inputSortableParameters['limit'] = 15;
        $outputSortableParameters = $vehicleIndexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $vehicles = $vehicleIndexHelper->retrieve($sortableParameters);

        return $this->render('OrderBundle:header:vehicle_searchable_content.html.twig', [
            'vehicles' => $vehicles,
            'vehicleSortableParameters' => $sortableParameters,
        ]);
    }


}