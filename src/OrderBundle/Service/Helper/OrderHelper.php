<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/2/17
 * Time: 7:03 PM
 */

namespace OrderBundle\Service\Helper;


use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Entity\Workstation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderHelper
{

    private $requestStack;
    private $tokenStorage;
    private $entityManager;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->entityManager    = $entityManager;
    }

    public function getOrderHeader($orderHeaderId = null)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        if(null === $orderHeaderId)
        {
            $orderHeaderId = $request->get('orderHeaderId');
        }

        $orderHeader = $this->entityManager->getRepository('AppBundle:OrderHeader')->getOne($workshop, $orderHeaderId);

        return $orderHeader;
    }

    public function getWorkstations($orderHeaderId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $workstations = $this->entityManager->getRepository('AppBundle:Workstation')->retrieve($workshop);

        return $workstations;
    }

    public function getError($msg)
    {
        return new JsonResponse([
            'error' => 1,
            'messages' => [$msg],
        ]);
    }

    public function getSuccessMessage()
    {
        return new JsonResponse([
            'error' => 0,
        ]);
    }

    public function isRequestValid()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        return $request->isXmlHttpRequest() && $request->isMethod('POST') && $request->get('orderHeaderId');
    }

    public function changePriority(OrderHeader $orderHeader)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        if($orderHeader->getPriority() == true)
        {
            $orderHeader->setPriority(false);
        }
        else
        {
            $orderHeader->setPriority(true);
        }

        $em->persist($orderHeader);

        $em->flush();

        return true;
    }

    public function changeWorkstation(OrderHeader $orderHeader, $workstation)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        $orderHeader->setWorkstation($workstation);

        $em->persist($orderHeader);

        $em->flush();

        return true;
    }

    public function getWorkstation()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $workstation = $em->getRepository('AppBundle:Workstation')->getOne($workshop, $request->get('workstationId'));

        return $workstation;
    }

    public function setCompleted(OrderHeader $orderHeader)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        if(null == $orderHeader->getCompletedAt())
        {
            $dateTime = new \DateTime();

            $orderHeader->setCompletedAt($dateTime);
        }
        else
        {
            $dateTime = null;

            $orderHeader->setCompletedAt($dateTime);
        }

        $em->persist($orderHeader);

        $em->flush();

        return $dateTime;
    }

    public function setPaid(OrderHeader $orderHeader)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        if(null == $orderHeader->getPaidAt())
        {
            $dateTime = new \DateTime();

            $orderHeader->setPaidAt($dateTime);
        }
        else
        {
            $dateTime = null;

            $orderHeader->setPaidAt($dateTime);
        }

        $em->persist($orderHeader);

        $em->flush();

        return $dateTime;
    }

}