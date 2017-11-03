<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/2/17
 * Time: 7:03 PM
 */

namespace OrderBundle\Service\Helper;


use AppBundle\Entity\OrderFault;
use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\OrderSymptom;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Entity\Workstation;
use AppBundle\Service\Trade\Trade;
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
    private $trade;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, Trade $trade)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->entityManager    = $entityManager;
        $this->trade            = $trade;
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

    public function getSuccessMessage($data = [])
    {
        return new JsonResponse([
            'error' => 0,
            'data' => $data,
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

    public function pay(OrderHeader $orderHeader)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $amountPaid = $request->get('amountPaid');

        $amountPaid = $this->trade->normalize($amountPaid);

        $orderHeader->setAmountPaid($amountPaid);

        $em->persist($orderHeader);

        $em->flush();

        return $amountPaid;
    }


    public function retrieveSymptoms()
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $symptoms = $em->getRepository('AppBundle:OrderSymptom')->retrieve($workshop);

        return $symptoms;
    }

    public function addSymptom(OrderHeader $orderHeader)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $symptomName = $request->get('name');

        if(!$symptomName)
        {
            return $this->getError('Nic nie wpisano');
        }

        /** @var OrderSymptom $orderSymptom */
        foreach($orderHeader->getSymptoms() as $orderSymptom)
        {
            if($orderSymptom->getName() == $symptomName)
            {
                if($orderSymptom->getRemovedAt() === null && $orderSymptom->getDeletedAt() === null)
                {
                    return $this->getSuccessMessage(['present']);
                }

                $orderSymptom->setRemovedAt(null);
                $orderSymptom->setDeletedAt(null);

                $em->persist($orderSymptom);

                $em->flush();

                return $orderSymptom;
            }
        }

        $orderSymptom = new OrderSymptom();
        $orderSymptom->setOrderHeader($orderHeader);
        $orderSymptom->setCreatedAt(new \DateTime());
        $orderSymptom->setCreatedBy($user);
        $orderSymptom->setUpdatedBy($user);
        $orderSymptom->setName($symptomName);

        $em->persist($orderSymptom);

        $em->flush();

        return $orderSymptom;
    }

    public function removeSymptom(OrderHeader $orderHeader)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var OrderSymptom $orderSymptom */
        foreach($orderHeader->getSymptoms() as $orderSymptom)
        {
            if($orderSymptom->getId() == $request->get('id'))
            {
                $orderSymptom->setRemovedAt(new \DateTime());

                $em->persist($orderSymptom);

                $em->flush();
            }
        }

        return $this->getSuccessMessage();
    }

    public function retrieveFaults()
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $faults = $em->getRepository('AppBundle:OrderFault')->retrieve($workshop);

        return $faults;
    }

    public function addFault(OrderHeader $orderHeader)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $faultName = $request->get('name');

        if(!$faultName)
        {
            return $this->getError('Nic nie wpisano');
        }

        /** @var OrderFault $orderFault */
        foreach($orderHeader->getFaults() as $orderFault)
        {
            if($orderFault->getName() == $faultName)
            {
                if($orderFault->getRemovedAt() === null && $orderFault->getDeletedAt() === null)
                {
                    return $this->getSuccessMessage(['present']);
                }

                $orderFault->setRemovedAt(null);
                $orderFault->setDeletedAt(null);

                $em->persist($orderFault);

                $em->flush();

                return $orderFault;
            }
        }

        $orderFault = new OrderFault();
        $orderFault->setOrderHeader($orderHeader);
        $orderFault->setCreatedAt(new \DateTime());
        $orderFault->setCreatedBy($user);
        $orderFault->setUpdatedBy($user);
        $orderFault->setName($faultName);

        $em->persist($orderFault);

        $em->flush();

        return $orderFault;
    }

    public function removeFault(OrderHeader $orderHeader)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var OrderFault $orderFault */
        foreach($orderHeader->getFaults() as $orderFault)
        {
            if($orderFault->getId() == $request->get('id'))
            {
                $orderFault->setRemovedAt(new \DateTime());

                $em->persist($orderFault);

                $em->flush();
            }
        }

        return $this->getSuccessMessage();
    }


}