<?php

namespace OrderBundle\Service\Helper;

use AppBundle\Entity\Address;
use AppBundle\Entity\CarModel;
use AppBundle\Entity\Customer;
use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\OrderSymptom;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\Workshop;
use CustomerBundle\Service\Helper\CustomerAddHelper;
use CustomerBundle\Service\Helper\CustomerIndexHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use OrderBundle\Form\OrderHeaderAddType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use VehicleBundle\Service\Helper\VehicleAddHelper;
use VehicleBundle\Service\Helper\VehicleIndexHelper;

class OrderHeaderAddHelper
{
    private $tokenStorage;
    private $requestStack;
    private $entityManager;
    private $formFactory;
    private $customerIndexHelper;
    private $vehicleIndexHelper;
    private $vehicleAddHelper;
    private $customerAddHelper;

    public function __construct(TokenStorageInterface $tokenStorage, RequestStack $requestStack, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, CustomerIndexHelper $customerIndexHelper, VehicleIndexHelper $vehicleIndexHelper, VehicleAddHelper $vehicleAddHelper, CustomerAddHelper $customerAddHelper)
    {
        $this->tokenStorage     = $tokenStorage;
        $this->requestStack     = $requestStack;
        $this->entityManager    = $entityManager;
        $this->formFactory      = $formFactory;
        $this->customerIndexHelper  = $customerIndexHelper;
        $this->vehicleIndexHelper   = $vehicleIndexHelper;
        $this->vehicleAddHelper     = $vehicleAddHelper;
        $this->customerAddHelper    = $customerAddHelper;
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

        $customerId = $request->get('order_header_add')['customer_id'];

        /** @var Customer $customer */
        $customer = $em->getRepository('AppBundle:Customer')->getOne($workshop, $customerId);

        $vehicleId = $request->get('order_header_add')['vehicle_id'];

        /** @var Vehicle $vehicle */
        $vehicle = $em->getRepository('AppBundle:Vehicle')->getOne($workshop, $vehicleId);

        if(null !== $customer)
        {
            $orderHeader->setCustomer($customer);
        }

        if(null !== $vehicle)
        {
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
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();
        
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var OrderHeader $orderHeader */
        $orderHeader = $form->getData();

        $dateTime = new \DateTime();

        $orderHeader->setWorkshop($workshop);
        $orderHeader->setCreatedAt($dateTime);
        $orderHeader->setCreatedBy($user);
        $orderHeader->setUpdatedBy($user);

        $customer = $orderHeader->getCustomer();

        if(null === $orderHeader->getCustomerId())
        {
            $customer->setWorkshop($workshop);
            $customer->setCreatedAt($dateTime);
            $customer->setCreatedBy($user);
            $customer->setUpdatedBy($user);

            $address = $customer->getAddress();

            if(null !== $address)
            {
                $address = new Address();
                $customer->setAddress($address);
            }

            $address->setWorkshop($workshop);
            $address->setCreatedAt($dateTime);
            $address->setCreatedBy($user);
            $address->setUpdatedBy($user);

        }

        /** @var Customer $customer */
        $customer = $this->customerAddHelper->assignGroupps($customer);

        $vehicle = $orderHeader->getVehicle();

        if(null === $orderHeader->getVehicleId())
        {
            $vehicle->setWorkshop($workshop);
            $vehicle->setCreatedAt($dateTime);
            $vehicle->setCreatedBy($user);
            $vehicle->setUpdatedBy($user);
            $vehicle->setOwner($customer);

        }
        
        $brandName = $request->get('order_header_add')['vehicle']['car_brand'];
        $modelName = $request->get('order_header_add')['vehicle']['car_model'];
        
        /** @var CarModel $model */
        $model = $this->vehicleAddHelper->getModel($brandName, $modelName);
        
        $vehicle->setCarModel($model);

        $vehicle = $this->vehicleAddHelper->evaluateTradeValues($vehicle);

        $orderHeader = $this->setOrderNumbers($orderHeader);
        $orderHeader = $this->setSymptoms($orderHeader);

        $customer->addVehicle($vehicle);

        $em->persist($customer);
        $em->persist($vehicle);
        $em->persist($orderHeader);

        $em->flush();

        return $orderHeader->getId();
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


    public function setOrderNumbers(OrderHeader $orderHeader)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $countMonthly = $em->getRepository('AppBundle:OrderHeader')->getCountMonthly($workshop);
        $countYearly = $em->getRepository('AppBundle:OrderHeader')->getCountYearly($workshop);

        $numberMonthly = date('m') . '\\' . $countMonthly;
        $numberYearly = date('m') . '\\' . date('Y') . $countYearly;

        $orderHeader->setNumberMonthly($numberMonthly);
        $orderHeader->setNumberYearly($numberYearly);

        return $orderHeader;
    }

    public function setSymptoms(OrderHeader $orderHeader)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $dateTime = new \DateTime();

        /** @var OrderSymptom $symptom */
        foreach($orderHeader->getSymptoms() as $symptom)
        {
            $symptom->setCreatedAt($dateTime);
            $symptom->setCreatedBy($user);
            $symptom->setUpdatedBy($user);
            $symptom->setOrderHeader($orderHeader);

            $em->persist($symptom);
        }

        return $orderHeader;
    }

}