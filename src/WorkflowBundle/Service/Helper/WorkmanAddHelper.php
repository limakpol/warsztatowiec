<?php

namespace WorkflowBundle\Service\Helper;

use AppBundle\Entity\Address;
use AppBundle\Entity\User;
use AppBundle\Entity\UserRole;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Trade\Trade;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use WorkflowBundle\Form\WorkmanType;

class WorkmanAddHelper
{

    private $entityManager;
    private $tokenStorage;
    private $formFactory;
    private $requestStack;
    private $trade;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, FormFactoryInterface $formFactory, RequestStack $requestStack, Trade $trade)
    {
        $this->entityManager    = $entityManager;
        $this->tokenStorage     = $tokenStorage;
        $this->formFactory      = $formFactory;
        $this->requestStack     = $requestStack;
        $this->trade            = $trade;
    }

    public function createAddForm()
    {
        $address = new Address();
        $user = new User();
        $user->setAddress($address);

        $form = $this->formFactory->create(WorkmanType::class, [
            'user' => $user,
        ], [
            'validation_groups' => ['workman']
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
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var User $newUser */
        $newUser   = $form->getData()['user'];

        /** @var EntityManager $em */
        $em     = $this->entityManager;

        $dateTime = new \DateTime();

        $newUser->setCurrentWorkshop($workshop);
        $newUser->addWorkshop($workshop);
        $newUser->setUpdatedBy($user);
        $newUser->setCreatedBy($user);
        $newUser->setCreatedAt($dateTime);

        $address = $newUser->getAddress();
        $address->setCreatedBy($user);
        $address->setUpdatedBy($user);
        $address->setCreatedAt($dateTime);

        $userRole = new UserRole();
        $userRole->setWorkshop($workshop);
        $userRole->setUser($newUser);
        $userRole->setCreatedAt($dateTime);
        $userRole->setCreatedBy($user);
        $userRole->setUpdatedBy($user);
        $userRole->setRole(UserRole::ROLE_USER);

        $newUser->addRole($userRole);

       // var_dump($newUser->getHourlyRateNet()); die();

        $hourlyRateNet = $this->trade->normalize($newUser->getHourlyRateNet(), true);
        $newUser->setHourlyRateNet($hourlyRateNet);

        $em->persist($address);
        $em->persist($userRole);
        $em->persist($newUser);

        $em->flush();

        return $newUser->getId();
    }
}