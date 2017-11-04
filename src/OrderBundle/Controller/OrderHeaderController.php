<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/20/17
 * Time: 2:04 PM
 */

namespace OrderBundle\Controller;


use AppBundle\Entity\OrderFault;
use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\OrderSymptom;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use CustomerBundle\Service\Helper\CustomerIndexHelper;
use Doctrine\ORM\EntityManager;
use OrderBundle\Service\Helper\OrderHeaderAddHelper;
use OrderBundle\Service\Helper\OrderHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use VehicleBundle\Service\Helper\VehicleIndexHelper;

class OrderHeaderController extends Controller
{
    public function addAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        $orderHeaderAddHelper   = $this->get('order.helper.header_add');
        $orderHelper = $this->get('order.helper');

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
        $symptoms = $orderHelper->retrieveSymptoms();

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
            'symptoms'      => $symptoms,
        ]);
    }

    public function retrieveCustomersAction()
    {

        /** @var OrderHeaderAddHelper $orderHeaderAddHelper */
        $orderHeaderAddHelper = $this->get('order.helper.header_add');

        /** @var CustomerIndexHelper $customerIndexHelper */
        $customerIndexHelper = $this->get('customer.helper.index');

        $sortableParameters = $orderHeaderAddHelper->getCustomerSortableParameters();

        $customers = $customerIndexHelper->retrieve($sortableParameters);

        return $this->render('OrderBundle:header:customer_searchable_content.html.twig', [
            'customers' => $customers,
            'customerSortableParameters' => $sortableParameters,
        ]);
    }

    public function retrieveVehiclesAction()
    {
        /** @var OrderHeaderAddHelper $orderHeaderAddHelper */
        $orderHeaderAddHelper = $this->get('order.helper.header_add');

        /** @var VehicleIndexHelper $vehicleIndexHelper */
        $vehicleIndexHelper = $this->get('vehicle.helper.index');

        $sortableParameters = $orderHeaderAddHelper->getVehicleSortableParameters();

        $vehicles = $vehicleIndexHelper->retrieve($sortableParameters);

        return $this->render('OrderBundle:header:vehicle_searchable_content.html.twig', [
            'vehicles' => $vehicles,
            'vehicleSortableParameters' => $sortableParameters,
        ]);
    }

    public function retrieveSymptomsAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $symptoms = $em->getRepository('AppBundle:OrderSymptom')->retrieveNames($workshop);

        return $symptoms;
    }

    public function changePriorityAction()
    {
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');

        if(!$orderHelper->isRequestValid())
        {
            return $orderHelper->getError('Nieprawidłowe żądanie');
        }

        /** @var OrderHeader $orderHeader */
        $orderHeader = $orderHelper->getOrderHeader();

        if(null === $orderHeader)
        {
            return $orderHelper->getError('Nie ma takiego zlecenia');
        }

        $orderHelper->changePriority($orderHeader);

        return $orderHelper->getSuccessMessage();
    }

    public function changeWorkstationAction()
    {
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');

        if(!$orderHelper->isRequestValid())
        {
            return $orderHelper->getError('Nieprawidłowe żądanie');
        }

        /** @var OrderHeader $orderHeader */
        $orderHeader = $orderHelper->getOrderHeader();

        if(null === $orderHeader)
        {
            return $orderHelper->getError('Nie ma takiego zlecenia');
        }

        $workstation = $orderHelper->getWorkstation();

        $orderHelper->changeWorkstation($orderHeader, $workstation);

        return $orderHelper->getSuccessMessage();
    }

    public function setCompletedAction()
    {
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');

        if(!$orderHelper->isRequestValid())
        {
            return $orderHelper->getError('Nieprawidłowe żądanie');
        }

        /** @var OrderHeader $orderHeader */
        $orderHeader = $orderHelper->getOrderHeader();

        if(null === $orderHeader)
        {
            return $orderHelper->getError('Nie ma takiego zlecenia');
        }

        $dateTime = $orderHelper->setCompleted($orderHeader);

        return $this->render('OrderBundle::date_or_no.html.twig', [
            'dateTime' => $dateTime,
        ]);
    }

    public function setPaidAction()
    {
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');

        if(!$orderHelper->isRequestValid())
        {
            return $orderHelper->getError('Nieprawidłowe żądanie');
        }

        /** @var OrderHeader $orderHeader */
        $orderHeader = $orderHelper->getOrderHeader();

        if(null === $orderHeader)
        {
            return $orderHelper->getError('Nie ma takiego zlecenia');
        }

        $dateTime = $orderHelper->setPaid($orderHeader);

        return $this->render('OrderBundle::date_or_no.html.twig', [
            'dateTime' => $dateTime,
        ]);
    }

    public function payAction()
    {
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');

        if(!$orderHelper->isRequestValid())
        {
            return $orderHelper->getError('Nieprawidłowe żądanie');
        }

        /** @var OrderHeader $orderHeader */
        $orderHeader = $orderHelper->getOrderHeader();

        if(null === $orderHeader)
        {
            return $orderHelper->getError('Nie ma takiego zlecenia');
        }

        $amountPaid = $orderHelper->pay($orderHeader);

        return $orderHelper->getSuccessMessage([$amountPaid]);
    }

    public function addSymptomAction()
    {
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');


        if(!$orderHelper->isRequestValid())
        {
            return $orderHelper->getError('Nieprawidłowe żądanie');
        }

        /** @var OrderHeader $orderHeader */
        $orderHeader = $orderHelper->getOrderHeader();

        if(null === $orderHeader)
        {
            return $orderHelper->getError('Nie ma takiego zlecenia');
        }

        if(($orderSymptom = $orderHelper->addSymptom($orderHeader)) instanceof OrderSymptom)
        {
            return $this->render('OrderBundle::inputable_symptom.html.twig', [
                'orderSymptom' => $orderSymptom,
            ]);
        }

        return $orderSymptom;
    }

    public function removeSymptomAction()
    {
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');


        if(!$orderHelper->isRequestValid())
        {
            return $orderHelper->getError('Nieprawidłowe żądanie');
        }

        /** @var OrderHeader $orderHeader */
        $orderHeader = $orderHelper->getOrderHeader();

        if(null === $orderHeader)
        {
            return $orderHelper->getError('Nie ma takiego zlecenia');
        }

        return $orderHelper->removeSymptom($orderHeader);
    }

    public function addFaultAction()
    {
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');


        if(!$orderHelper->isRequestValid())
        {
            return $orderHelper->getError('Nieprawidłowe żądanie');
        }

        /** @var OrderHeader $orderHeader */
        $orderHeader = $orderHelper->getOrderHeader();

        if(null === $orderHeader)
        {
            return $orderHelper->getError('Nie ma takiego zlecenia');
        }

        if(($orderFault = $orderHelper->addFault($orderHeader)) instanceof OrderFault)
        {
            return $this->render('OrderBundle::inputable_fault.html.twig', [
                'orderFault' => $orderFault,
            ]);
        }

        return $orderFault;
    }

    public function removeFaultAction()
    {
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');


        if(!$orderHelper->isRequestValid())
        {
            return $orderHelper->getError('Nieprawidłowe żądanie');
        }

        /** @var OrderHeader $orderHeader */
        $orderHeader = $orderHelper->getOrderHeader();

        if(null === $orderHeader)
        {
            return $orderHelper->getError('Nie ma takiego zlecenia');
        }

        return $orderHelper->removeFault($orderHeader);
    }

}