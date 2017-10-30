<?php

namespace WarehouseBundle\Service\Helper;

use AppBundle\Entity\Producer;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ProducerHelper
{
    private $entityManager;
    private $requestStack;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager    = $entityManager;
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
    }

    public function isRequestCorrect()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        return $request->isMethod('POST')  && $request->isXmlHttpRequest();
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

        return $request->get('name') != '' && strlen($request->get('name')) <= 40;
    }

    public function getProducers()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $producers = $this
            ->entityManager
            ->getRepository('AppBundle:Producer')
            ->retrieve($workshop);

        return $producers;
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
            ->getRepository('AppBundle:Producer')
            ->getOne($workshop, $id);
    }


    public function producerExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $producer    = $this
            ->entityManager
            ->getRepository('AppBundle:Producer')
            ->getOneByName($workshop, $name)
        ;

        return null !== $producer;
    }

    public function producerExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $producer = $this
            ->entityManager
            ->getRepository('AppBundle:Producer')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $producer;
    }

    public function recover(Producer $producer)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $producer->setName($name);

        $producer->setDeletedAt(null);
        $producer->setRemovedAt(null);
        $producer->setRemovedBy(null);
        $producer->setDeletedBy(null);
        $producer->setUpdatedBy($user);

        $em->persist($producer);

        $em->flush();

        return $producer;
    }

    public function write()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $producer    = new Producer();

        $producer->setCreatedAt(new \DateTime());
        $producer->setCreatedBy($user);
        $producer->setUpdatedBy($user);
        $producer->setWorkshop($user->getCurrentWorkshop());

        $producer->setName($name);

        $em->persist($producer);

        $em->flush();

        return $producer;
    }

    public function edit(Producer $producer)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $producer->setName($name);
        $producer->setUpdatedBy($user);

        $em->persist($producer);

        $em->flush();

        return true;
    }

    public function remove(Producer $producer)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $producer->setRemovedAt(new \DateTime());
        $producer->setRemovedBy($user);
        $producer->setUpdatedBy($user);

        $em->persist($producer);

        $em->flush();

        return true;
    }

    public function isLast()
    {

        return $this->getProducers()->count() == 1;
    }
}