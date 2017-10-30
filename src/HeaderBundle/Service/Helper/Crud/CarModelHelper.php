<?php

namespace HeaderBundle\Service\Helper\Crud;


use AppBundle\Entity\CarBrand;
use AppBundle\Entity\CarModel;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CarModelHelper
{
    private $entityManager;
    private $requestStack;
    private $tokenStorage;
    private $brandHelper;

    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack, TokenStorageInterface $tokenStorage, CarBrandHelper $brandHelper)
    {
        $this->entityManager    = $entityManager;
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->brandHelper      = $brandHelper;
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

        return  $request->get('name') != '' && strlen($request->get('name')) <= 20;
    }

    public function getBrand()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $brand = $em
            ->getRepository('AppBundle:CarBrand')
            ->getOne($workshop, $request->get('brandId'))
        ;

        return $brand;
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
            ->getRepository('AppBundle:CarModel')
            ->getOne($workshop, $id);
    }

    public function getModels($brandId)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $models = $em->getRepository('AppBundle:CarModel')->retrieveByBrandId($workshop, $brandId);

        return $models;
    }

    public function modelExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $model = $this
            ->entityManager
            ->getRepository('AppBundle:CarModel')
            ->getOneByName($workshop, $name)
        ;

        return null !== $model;
    }

    public function modelExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $model      = $this
            ->entityManager
            ->getRepository('AppBundle:CarModel')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $model;
    }

    public function restore(CarModel $model)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $model->setName($name);

        $model->setDeletedAt(null);
        $model->setRemovedAt(null);
        $model->setRemovedBy(null);
        $model->setDeletedBy(null);
        $model->setUpdatedBy($user);

        $em->persist($model);

        $em->flush();

        return true;
    }


    public function write(CarBrand $brand)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $model    = new CarModel();

        $model->setCreatedAt(new \DateTime());
        $model->setCreatedBy($user);
        $model->setUpdatedBy($user);
        $model->setBrand($brand);

        $model->setName($name);

        $em->persist($model);

        $em->flush();

        return true;
    }

    public function edit(CarModel $model)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $model->setName($name);
        $model->setUpdatedBy($user);

        $em->persist($model);

        $em->flush();

        return true;
    }

    public function remove(CarModel $model)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $model->setRemovedAt(new \DateTime());
        $model->setRemovedBy($user);
        $model->setUpdatedBy($user);

        $em->persist($model);

        $em->flush();

        return true;
    }

    public function othersSimilarExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');
        $id         = $request->get('id');

        $measures   = $this
            ->entityManager
            ->getRepository('AppBundle:CarModel')
            ->getOthersSimilar($workshop, $name, $id);

        return count($measures) > 0;
    }
}