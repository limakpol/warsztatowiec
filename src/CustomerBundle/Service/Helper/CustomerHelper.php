<?php

namespace CustomerBundle\Service\Helper;

use AppBundle\Entity\Address;
use AppBundle\Entity\Customer;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use CustomerBundle\Form\CustomerType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CustomerHelper
{

    private $requestStack;
    private $tokenStorage;
    private $formFactory;
    private $entityManager;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->formFactory      = $formFactory;
        $this->entityManager    = $entityManager;
    }

    public function createAddForm()
    {
        $customer = new Customer();

        $form = $this->formFactory->create(CustomerType::class, $customer, [
            'validation_groups' => ['customer']
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

        /** @var Customer $customer */
        $customer = $form->getData();

        /** @var Address $address */
        $address = $customer->getAddress();

        $dateTime = new \DateTime();

        $address->setCreatedAt($dateTime);
        $address->setCreatedBy($user);
        $address->setUpdatedBy($user);

        $customer->setCreatedAt($dateTime);
        $customer->setWorkshop($workshop);

        $em->persist($address);
        $em->persist($customer);

        $em->flush();

        return;
    }

}