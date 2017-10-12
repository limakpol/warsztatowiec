<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/24/17
 * Time: 6:22 AM
 */

namespace HeaderBundle\Service\Helper\Crud;

use AppBundle\Entity\Category;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CategoryHelper
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

    public function getCategories()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $categories = $this
            ->entityManager
            ->getRepository('AppBundle:Category')
            ->retrieve($workshop);

        return $categories;
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
            ->getRepository('AppBundle:Category')
            ->getOne($workshop, $id);
    }


    public function categoryExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $category    = $this
            ->entityManager
            ->getRepository('AppBundle:Category')
            ->getOneByName($workshop, $name)
        ;

        return null !== $category;
    }

    public function categoryExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $category = $this
            ->entityManager
            ->getRepository('AppBundle:Category')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $category;
    }

    public function restore(Category $category)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $category->setName($name);

        $category->setDeletedAt(null);
        $category->setRemovedAt(null);
        $category->setRemovedBy(null);
        $category->setDeletedBy(null);
        $category->setUpdatedBy($user);

        $em->persist($category);

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

        $category    = new Category();

        $category->setCreatedAt(new \DateTime());
        $category->setCreatedBy($user);
        $category->setUpdatedBy($user);
        $category->setWorkshop($user->getCurrentWorkshop());

        $category->setName($name);

        $em->persist($category);

        $em->flush();

        return true;
    }

    public function edit(Category $category)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $category->setName($name);
        $category->setUpdatedBy($user);

        $em->persist($category);

        $em->flush();

        return true;
    }

    public function remove(Category $category)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $category->setRemovedAt(new \DateTime());
        $category->setRemovedBy($user);
        $category->setUpdatedBy($user);

        $em->persist($category);

        $em->flush();

        return true;
    }

    public function isLast()
    {

        return $this->getCategories()->count() == 1;
    }

}