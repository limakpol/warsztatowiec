<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/4/17
 * Time: 2:19 PM
 */

namespace OrderBundle\Service\Helper;


use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\OrderIndexx;
use AppBundle\Entity\OrderService;
use AppBundle\Entity\Service;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Trade\Trade;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use OrderBundle\Form\OrderServiceType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderServiceHelper
{
    private $requestStack;
    private $tokenStorage;
    private $formFactory;
    private $entityManager;
    private $container;
    private $trade;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, ContainerInterface $container, Trade $trade)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->formFactory      = $formFactory;
        $this->entityManager    = $entityManager;
        $this->container        = $container;
        $this->trade            = $trade;
    }

    public function getHeader($orderHeaderId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $orderHeader = $em->getRepository('AppBundle:OrderHeader')->getOne($workshop, $orderHeaderId);

        return $orderHeader;
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

        $orderService = new OrderService();

        $serviceId = $request->get('order_service')['service_id'];

        $service = $em->getRepository('AppBundle:Service')->getOne($workshop, $serviceId);

        if(null === $service)
        {
            $service = new Service();
        }

        $orderService->setService($service);

        $form = $this->formFactory->create(OrderServiceType::class, $orderService, [
           'validation_groups' => ['order_service_add', 'service'],
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

    public function write(Form $form, OrderHeader $orderHeader)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var OrderService $orderService */
        $orderService = $form->getData();

        $dateTime = new \DateTime();

        $orderService->setOrderHeader($orderHeader);
        $orderHeader->addOrderService($orderService);
        $orderService->setCreatedAt($dateTime);
        $orderService->setCreatedBy($user);
        $orderService->setUpdatedBy($user);

        $service = $orderService->getService();

        if(null === $orderService->getServiceId())
        {
            $service->setWorkshop($workshop);
            $service->setCreatedAt($dateTime);
            $service->setCreatedBy($user);
            $service->setUpdatedBy($user);
        }

        $orderService = $this->trade->evaluateDetail($orderService);
        $orderService = $this->setServiceUnitPriceNet($orderService);
        $orderHeader  = $this->trade->evaluateOrderHeader($orderHeader);

        $em->persist($service);
        $em->persist($orderService);
        $em->persist($orderHeader);

        $em->flush();

        return true;
    }

    public function retrieveServices($sortableParameters = [])
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        if(!$sortableParameters)
        {
            $sortableParameters = $this->getSortableParamaters();
        }

        $services = $this->entityManager->getRepository('AppBundle:Service')->retrieve($workshop, $sortableParameters);

        return $services;
    }

    public function getSortableParamaters()
    {
        $inputSortableParameters    = $this->getInputSortableParameters();
        $outputSortableParameters   = $this->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters         = array_merge($inputSortableParameters, $outputSortableParameters);

        return $sortableParameters;
    }


    public function getInputSortableParameters()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        $sortableParameters = (array) json_decode($request->get('sortableParameters'), true);

        if(!$sortableParameters )
        {
            $sortableParameters = [
                'search' => '',
                'limit' => 15,
                'currentPage' => 1,
                'requestedPage' => 1,
                'sortOrder' => 'ASC',
                'sortColumnName' => 's.name',
            ];
        }
        else
        {
            $limitSet = $this->container->getParameter('app')['limit_set'];

            if(!in_array($sortableParameters['limit'], $limitSet))
            {
                $sortableParameters['limit'] = 15;
            }
        }

        return $sortableParameters;
    }

    public function getOutputSortableParameters($inputSortableParameters)
    {

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $limit          = (int) $inputSortableParameters['limit'];
        $currentPage    = (int) $inputSortableParameters['currentPage'];
        $requestedPage  = (int) $inputSortableParameters['requestedPage'];

        $countAllRetrieved = $em->getRepository('AppBundle:Service')->getCountAllRetrieved($workshop, $inputSortableParameters);

        $lastPage = (int) floor(abs($countAllRetrieved-1)/$limit)+1;

        if($requestedPage > 1)
        {
            $currentPage += 1;
        }

        if($requestedPage < 1)
        {
            $currentPage -= 1;
        }

        if($currentPage > $lastPage || $requestedPage == 1)
        {
            $currentPage = 1;
        }

        if($currentPage < 1)
        {
            $currentPage = $lastPage;
        }

        $offset = ($currentPage-1)*$limit;

        $outputSortableParameters = [
            'offset'        => $offset,
            'currentPage'   => $currentPage,
            'lastPage'      => $lastPage,
            'countAll'      => $countAllRetrieved,
        ];

        return $outputSortableParameters;
    }

    public function setServiceUnitPriceNet(OrderService $orderService)
    {
        $service = $orderService->getService();

        if(null !== $service->getUnitPriceNet())
        {
            return $orderService;
        }

        $service->setUnitPriceNet($orderService->getUnitPriceNet());

        return $orderService;
    }
}