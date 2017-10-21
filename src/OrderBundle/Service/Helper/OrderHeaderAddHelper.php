<?php

namespace OrderBundle\Service\Helper;

use AppBundle\Entity\Address;
use AppBundle\Entity\Customer;
use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\Workshop;
use CustomerBundle\Service\Helper\CustomerIndexHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use OrderBundle\Form\OrderHeaderAddType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use VehicleBundle\Service\Helper\VehicleIndexHelper;

class OrderHeaderAddHelper
{
    private $tokenStorage;
    private $requestStack;
    private $entityManager;
    private $formFactory;
    private $customerIndexHelper;
    private $vehicleIndexHelper;

    public function __construct(TokenStorageInterface $tokenStorage, RequestStack $requestStack, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, CustomerIndexHelper $customerIndexHelper, VehicleIndexHelper $vehicleIndexHelper)
    {
        $this->tokenStorage     = $tokenStorage;
        $this->requestStack     = $requestStack;
        $this->entityManager    = $entityManager;
        $this->formFactory      = $formFactory;
        $this->customerIndexHelper = $customerIndexHelper;
        $this->vehicleIndexHelper = $vehicleIndexHelper;
    }

    public function createForm()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $orderHeader = new OrderHeader();

        $customerId = $request->get('delivery_header_add')['customer_id'];

        $customer = $em->getRepository('AppBundle:Customer')->getOne($workshop, $customerId);

        $vehicleId = $request->get('delivery_header_add')['vehicle_id'];

        $vehicle = $em->getRepository('AppBundle:Customer')->getOne($workshop, $vehicleId);

        if(null === $customer)
        {
            $address = new Address();
            $customer = new Customer();
            $customer->setAddress($address);
            $orderHeader->setCustomer($customer);
        }

        if(null === $vehicle)
        {
            $vehicle = new Vehicle();
            $orderHeader->setVehicle($vehicle);
        }

        $form = $this->formFactory->create(OrderHeaderAddType::class, $orderHeader, [
            'validation_groups' => ['order_header_add', 'customer', 'vehicle'],
        ]);

        return $form;
    }

    public function isValid(Form $form)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        if($request->isMethod('POST'))
        {
            $form->submit($request->request->get($form->getName()));

            return $form->isValid();
        }

        return false;
    }

    public function write(Form $form)
    {

        return;
    }

    public function getCustomerSortableParameters()
    {
        $customerIndexHelper = $this->customerIndexHelper;

        $inputSortableParameters = $customerIndexHelper->getInputSortableParameters();
        $inputSortableParameters['limit'] = 15;
        $outputSortableParameters = $customerIndexHelper->getOutputSortableParameters($inputSortableParameters);

        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        return $sortableParameters;
    }

    public function getVehicleSortableParameters()
    {
        $vehicleIndexHelper = $this->vehicleIndexHelper;

        $inputSortableParameters = $vehicleIndexHelper->getInputSortableParameters();
        $inputSortableParameters['limit'] = 15;
        $outputSortableParameters = $vehicleIndexHelper->getOutputSortableParameters($inputSortableParameters);

        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        return $sortableParameters;
    }



}