<?php

namespace DeliveryBundle\Service\Helper;

use AppBundle\Entity\Address;
use AppBundle\Entity\Customer;
use AppBundle\Entity\DeliveryHeader;
use AppBundle\Entity\Groupp;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Trade\Trade;
use CustomerBundle\Service\Helper\CustomerAddHelper;
use CustomerBundle\Service\Helper\CustomerIndexHelper;
use DeliveryBundle\Form\DeliveryHeaderAddType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DeliveryHeaderAddHelper
{
    private $tokenStorage;
    private $requestStack;
    private $entityManager;
    private $formFactory;
    private $customerIndexHelper;
    private $customerAddHelper;
    private $trade;

    public function __construct(TokenStorageInterface $tokenStorage, RequestStack $requestStack, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, CustomerIndexHelper $customerIndexHelper, CustomerAddHelper $customerAddHelper, Trade $trade)
    {
        $this->tokenStorage     = $tokenStorage;
        $this->requestStack     = $requestStack;
        $this->entityManager    = $entityManager;
        $this->formFactory      = $formFactory;
        $this->customerIndexHelper = $customerIndexHelper;
        $this->customerAddHelper = $customerAddHelper;
        $this->trade            = $trade;
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

        $deliveryHeader = new DeliveryHeader();

        $customerId = $request->get('delivery_header_add')['customer_id'];

        $customer = $em->getRepository('AppBundle:Customer')->getOne($workshop, $customerId);

        $validationGroups = ['delivery_header_add'];

        if(null !== $customer)
        {
            array_push($validationGroups, "customer");
            $deliveryHeader->setCustomer($customer);
        }

        if($customerId === 'new')
        {
            $address = new Address();
            $customer = new Customer();
            $customer->setAddress($address);
            $deliveryHeader->setCustomer($customer);

            array_push($validationGroups, "customer");
        }

        $form = $this->formFactory->create(DeliveryHeaderAddType::class, $deliveryHeader, [
            'validation_groups' => $validationGroups,
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
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var DeliveryHeader $deliveryHeader */
        $deliveryHeader = $form->getData();

        $dateTime = new \DateTime();

        $deliveryHeader->setWorkshop($workshop);
        $deliveryHeader->setCreatedAt($dateTime);
        $deliveryHeader->setCreatedBy($user);
        $deliveryHeader->setUpdatedBy($user);

        if(null === $deliveryHeader->getCustomerId())
        {
            $deliveryHeader->setCustomer(null);
        }
        else
        {
            $customer = $deliveryHeader->getCustomer();

            if($deliveryHeader->getCustomerId() == 'new')
            {
                $customer
                    ->setWorkshop($workshop)
                    ->setCreatedBy($user)
                    ->setUpdatedBy($user)
                    ->setCreatedAt($dateTime)
                ;
            }

            $address = $customer->getAddress();

            if($deliveryHeader->getCustomerId() == 'new')
            {
                $address->setCreatedAt($dateTime);
                $address->setCreatedBy($user);
                $address->setUpdatedBy($user);

                $customer->setAddress($address);
            }

            $customer = $this->customerAddHelper->assignGroupps($customer);

            $em->persist($address);
            $em->persist($customer);
        }

        $deliveryHeader = $this->trade->normalizeHeader($deliveryHeader);

        $em->persist($deliveryHeader);

        $em->flush();

        return $deliveryHeader->getId();
    }

    public function getSortableParameters()
    {
        $customerIndexHelper = $this->customerIndexHelper;

        $inputSortableParameters = $customerIndexHelper->getInputSortableParameters();
        $inputSortableParameters['limit'] = 15;
        $inputSortableParameters['systemFilters'] = ['supplier'];
        $outputSortableParameters = $customerIndexHelper->getOutputSortableParameters($inputSortableParameters);

        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        return $sortableParameters;
    }

}