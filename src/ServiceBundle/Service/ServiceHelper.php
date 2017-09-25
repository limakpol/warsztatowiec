<?php

namespace ServiceBundle\Service;

use AppBundle\Entity\Measure;
use AppBundle\Entity\Service;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Service\PriceTransformer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ServiceHelper
{
    private $entityManager;
    private $requestStack;
    private $tokenStorage;
    private $priceTransformer;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, TokenStorageInterface $tokenStorage, PriceTransformer $priceTransformer)
    {
        $this->entityManager    = $entityManager;
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->priceTransformer = $priceTransformer;
    }

    public function isRequestCorrect()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        return $request->isMethod('POST')  &&  $request->isXmlHttpRequest();
    }

    public function getErrorMessage($message)
    {
        return new JsonResponse([
            'error' => 1,
            'messages' => [$message],
        ]);
    }

    public function getSuccessMessage()
    {
        return new JsonResponse([
            'error' => 0,
        ]);
    }

    public function isValid()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        return $request->get('name') != '';
    }

    public function getServices()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $services = $this
            ->entityManager
            ->getRepository('AppBundle:Service')
            ->retrieve($workshop);

        return $services;
    }

    public function getOne()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $id = $request->get('id');

        return $this
            ->entityManager
            ->getRepository('AppBundle:Service')
            ->getOne($workshop, $id);
    }


    public function serviceExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $service    = $this
            ->entityManager
            ->getRepository('AppBundle:Service')
            ->getOneByName($workshop, $name)
        ;

        return null !== $service;
    }

    public function serviceExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $service = $this
            ->entityManager
            ->getRepository('AppBundle:Service')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $service;
    }

    public function recover(Service $service)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $service->setName($name);

        $service->setDeletedAt(null);
        $service->setRemovedAt(null);
        $service->setRemovedBy(null);
        $service->setDeletedBy(null);
        $service->setUpdatedBy($user);

        $em->persist($service);

        $em->flush();

        return true;
    }

    public function write()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');
        $measureId  = $request->get('measureId');
        $unitPriceNet = $request->get('unitPriceNet');

        /** @var Measure $measure */
        $measure    = $em->getRepository('AppBundle:Measure')->getOne($workshop, $measureId);

        $service    = new Service();

        $service->setCreatedAt(new \DateTime());
        $service->setCreatedBy($user);
        $service->setUpdatedBy($user);
        $service->setWorkshop($user->getCurrentWorkshop());
        $service->setName($name);

        if(null !== $measure && $measure->getTypeOfQuantity() == 'service')
        {
            $service->setMeasure($measure);
        }

        if($unitPriceNet != '')
        {
            $unitPriceNet = $this->priceTransformer->transform($unitPriceNet);
        }
        else
        {
            $unitPriceNet = null;
        }

        $service->setUnitPriceNet($unitPriceNet);

        $em->persist($service);

        $em->flush();

        return true;
    }

    public function edit(Service $service)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');
        $measureId  = $request->get('measureId');
        $unitPriceNet = $request->get('unitPriceNet');

        $service->setName($name);
        $service->setUpdatedBy($user);

        /** @var Measure $measure */
        $measure    = $em->getRepository('AppBundle:Measure')->getOne($workshop, $measureId);

        if(null !== $measure && $measure->getTypeOfQuantity() == 'service')
        {
            $service->setMeasure($measure);
        }

        if($unitPriceNet != '')
        {
            $unitPriceNet = $this->priceTransformer->transform($unitPriceNet);
        }
        else
        {
            $unitPriceNet = null;
        }

        $service->setUnitPriceNet($unitPriceNet);

        $em->persist($service);

        $em->flush();

        return true;
    }

    public function remove(Service $service)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $service->setRemovedAt(new \DateTime());
        $service->setRemovedBy($user);
        $service->setUpdatedBy($user);

        $em->persist($service);

        $em->flush();

        return true;
    }

    public function isLast()
    {

        return $this->getServices()->count() == 1;
    }

    public function getMeasures()
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $measures = $workshop->getMeasures()->filter(function(Measure $measure) {

            return
                    $measure->getRemovedAt()        === null
                &&  $measure->getDeletedAt()        === null
                &&  $measure->getTypeOfQuantity()   == 'service';
        });

        return $measures;
    }
}