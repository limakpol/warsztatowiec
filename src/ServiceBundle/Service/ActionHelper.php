<?php

namespace ServiceBundle\Service;

use AppBundle\Entity\Action;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ActionHelper
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

    public function getActions()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $actions = $this
            ->entityManager
            ->getRepository('AppBundle:Action')
            ->retrieve($workshop);

        return $actions;
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
            ->getRepository('AppBundle:Action')
            ->getOne($workshop, $id);
    }


    public function actionExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $action    = $this
            ->entityManager
            ->getRepository('AppBundle:Action')
            ->getOneByName($workshop, $name)
        ;

        return null !== $action;
    }

    public function actionExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $action = $this
            ->entityManager
            ->getRepository('AppBundle:Action')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $action;
    }

    public function recover(Action $action)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $action->setName($name);

        $action->setDeletedAt(null);
        $action->setRemovedAt(null);
        $action->setRemovedBy(null);
        $action->setDeletedBy(null);
        $action->setUpdatedBy($user);

        $em->persist($action);

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

        $name       = $request->get('name');

        $action    = new Action();

        $action->setCreatedAt(new \DateTime());
        $action->setCreatedBy($user);
        $action->setUpdatedBy($user);
        $action->setWorkshop($user->getCurrentWorkshop());

        $action->setName($name);

        $em->persist($action);

        $em->flush();

        return true;
    }

    public function edit(Action $action)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $action->setName($name);
        $action->setUpdatedBy($user);

        $em->persist($action);

        $em->flush();

        return true;
    }

    public function remove(Action $action)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $action->setRemovedAt(new \DateTime());
        $action->setRemovedBy($user);
        $action->setUpdatedBy($user);

        $em->persist($action);

        $em->flush();

        return true;
    }

    public function isLast()
    {

        return $this->getActions()->count() == 1;
    }
}