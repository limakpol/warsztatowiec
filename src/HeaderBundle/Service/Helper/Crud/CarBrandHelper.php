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

class CarBrandHelper
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

        return  $request->get('name') != '' && strlen($request->get('name')) <= 20;
    }


    public function getBrands()
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $brands = $em->getRepository('AppBundle:CarBrand')->retrieve($workshop);

        return $brands;
    }

    public function brandExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $brand = $this
            ->entityManager
            ->getRepository('AppBundle:CarBrand')
            ->getOneByName($workshop, $name)
        ;

        return null !== $brand;
    }

    public function brandExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $brand      = $this
            ->entityManager
            ->getRepository('AppBundle:CarBrand')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $brand;
    }

    public function restore(CarBrand $brand)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $brand->setName($name);

        $brand->setDeletedAt(null);
        $brand->setRemovedAt(null);
        $brand->setRemovedBy(null);
        $brand->setDeletedBy(null);
        $brand->setUpdatedBy($user);

        $em->persist($brand);

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

        $brand    = new CarBrand();

        $brand->setCreatedAt(new \DateTime());
        $brand->setCreatedBy($user);
        $brand->setUpdatedBy($user);
        $brand->setWorkshop($user->getCurrentWorkshop());

        $brand->setName($name);

        $em->persist($brand);

        $em->flush();

        return $brand;
    }

    public function edit(CarBrand $brand)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $brand->setName($name);
        $brand->setUpdatedBy($user);

        $em->persist($brand);

        $em->flush();

        return true;
    }

    public function remove(CarBrand $brand)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $brand->setRemovedAt(new \DateTime());
        $brand->setRemovedBy($user);
        $brand->setUpdatedBy($user);

        $em->persist($brand);

        $em->flush();

        return true;
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
            ->getRepository('AppBundle:CarBrand')
            ->getOne($workshop, $id);
    }

    public function getOneById($brandId)
    {

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        return $this
            ->entityManager
            ->getRepository('AppBundle:CarBrand')
            ->getOne($workshop, $brandId);
    }

    public function getOneByName()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $brand = $this->entityManager
            ->getRepository('AppBundle:CarBrand')
            ->getOneByName($workshop, $request->get('brandName'))
            ;

        return $brand;
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
            ->getRepository('AppBundle:CarBrand')
            ->getOthersSimilar($workshop, $name, $id);

        return count($measures) > 0;
    }

}