<?php

namespace SaleBundle\Service\Helper;

use AppBundle\Entity\Address;
use AppBundle\Entity\Customer;
use AppBundle\Entity\SaleHeader;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Trade\Trade;
use CustomerBundle\Service\Helper\CustomerAddHelper;
use CustomerBundle\Service\Helper\CustomerIndexHelper;
use SaleBundle\Form\SaleHeaderAddType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class SaleHeaderAddHelper
{
    private $tokenStorage;
    private $requestStack;
    private $entityManager;
    private $formFactory;
    private $customerIndexHelper;
    private $customerAddHelper;

    public function __construct(TokenStorageInterface $tokenStorage, RequestStack $requestStack, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, CustomerIndexHelper $customerIndexHelper, CustomerAddHelper $customerAddHelper)
    {
        $this->tokenStorage     = $tokenStorage;
        $this->requestStack     = $requestStack;
        $this->entityManager    = $entityManager;
        $this->formFactory      = $formFactory;
        $this->customerIndexHelper = $customerIndexHelper;
        $this->customerAddHelper = $customerAddHelper;
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

        $saleHeader = new SaleHeader();

        $customerId = $request->get('sale_header_add')['customer_id'];

        $customer = $em->getRepository('AppBundle:Customer')->getOne($workshop, $customerId);

        $validationGroups = ['sale_header_add'];

        if(null !== $customer)
        {
            array_push($validationGroups, "customer");
            $saleHeader->setCustomer($customer);
        }

        if($customerId === 'new')
        {
            $address = new Address();
            $customer = new Customer();
            $customer->setAddress($address);
            $saleHeader->setCustomer($customer);

            array_push($validationGroups, "customer");
        }

        $form = $this->formFactory->create(SaleHeaderAddType::class, $saleHeader, [
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

        /** @var SaleHeader $saleHeader */
        $saleHeader = $form->getData();

        $dateTime = new \DateTime();

        $saleHeader->setWorkshop($workshop);
        $saleHeader->setCreatedAt($dateTime);
        $saleHeader->setCreatedBy($user);
        $saleHeader->setUpdatedBy($user);

        if(null === $saleHeader->getCustomerId())
        {
            $saleHeader->setCustomer(null);
        }

        if($saleHeader->getCustomerId() == 'new')
        {
            $customer = $saleHeader->getCustomer();

            $customer
                ->setWorkshop($workshop)
                ->setCreatedBy($user)
                ->setUpdatedBy($user)
                ->setCreatedAt($dateTime)
                ;

            $customer = $this->customerAddHelper->assignGroupps($customer);

            $address = $customer->getAddress();

            $address->setCreatedAt($dateTime);
            $address->setCreatedBy($user);
            $address->setUpdatedBy($user);

            $em->persist($address);

            $em->persist($customer);
        }


        $em->persist($saleHeader);

        $em->flush();

        return $saleHeader->getId();
    }

    public function getSortableParameters()
    {
        $customerIndexHelper = $this->customerIndexHelper;

        $inputSortableParameters = $customerIndexHelper->getInputSortableParameters();
        $inputSortableParameters['limit'] = 15;
        $inputSortableParameters['systemFilters'] = ['recipient'];
        $outputSortableParameters = $customerIndexHelper->getOutputSortableParameters($inputSortableParameters);

        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        return $sortableParameters;
    }

}