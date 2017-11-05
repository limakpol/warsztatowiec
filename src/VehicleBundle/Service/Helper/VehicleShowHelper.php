<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/5/17
 * Time: 7:01 AM
 */

namespace VehicleBundle\Service\Helper;

use AppBundle\Entity\Customer;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class VehicleShowHelper
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

    public function getVehicle($vehicleId)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $vehicle = $em->getRepository('AppBundle:Vehicle')->getOne($workshop, $vehicleId);

        return $vehicle;
    }

    public function getOrderHeaders(Vehicle $vehicle)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $orderHeaders = $em->getRepository('AppBundle:OrderHeader')->retrieveByVehicle($workshop, $vehicle);

        return $orderHeaders;
    }


}