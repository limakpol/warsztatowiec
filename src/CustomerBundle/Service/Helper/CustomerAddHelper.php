<?php

namespace CustomerBundle\Service\Helper;

use AppBundle\Entity\Address;
use AppBundle\Entity\Customer;
use AppBundle\Entity\Groupp;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use CustomerBundle\Form\CustomerType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CustomerAddHelper
{

    private $requestStack;
    private $tokenStorage;
    private $formFactory;
    private $entityManager;
    private $container;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->formFactory      = $formFactory;
        $this->entityManager    = $entityManager;
        $this->container        = $container;
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
        $customer->setCreatedBy($user);
        $customer->setUpdatedBy($user);
        $customer->setWorkshop($workshop);

        $customer = $this->assignGroupps($customer);

        $em->persist($address);
        $em->persist($customer);

        $em->flush();

        return;
    }

    public function retrieveGroupps()
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();


        return $em->getRepository('AppBundle:Groupp')->retrieve($workshop);
    }

    public function assignGroupps(Customer $customer)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $grouppNames = [];

        /** @var Groupp $groupp */
        foreach($customer->getGroupps() as $groupp)
        {
            $grouppNames[] = $groupp->getName();
        }

        $customer->getGroupps()->clear();

        /** @var Groupp $groupp */
        foreach($grouppNames as $grouppName)
        {

            $groupp     = $this->entityManager
                        ->getRepository('AppBundle:Groupp')
                        ->getOneByName($workshop, $grouppName);

            if(null === $groupp)
            {
                /** @var Groupp $groupp */
                $groupp     = $this->entityManager
                            ->getRepository('AppBundle:Groupp')
                            ->getOneRemovedByName($workshop, $grouppName);

                if(null === $groupp)
                {
                    $groupp = $this->createGroupp($user, $grouppName);
                }
                else
                {
                    $groupp->setRemovedBy(null);
                    $groupp->setRemovedAt(null);
                    $groupp->setDeletedBy(null);
                    $groupp->setDeletedAt(null);
                }
            }

            $em->persist($groupp);

            $customer->addGroupp($groupp);
        }

        return $customer;
    }

    public function createGroupp(User $user, $grouppName)
    {
        $groupp = new Groupp();
        $groupp->setName($grouppName);
        $groupp->setCreatedAt(new \DateTime());
        $groupp->setCreatedBy($user);
        $groupp->setUpdatedBy($user);
        $groupp->setWorkshop($user->getCurrentWorkshop());

        return $groupp;
    }
}