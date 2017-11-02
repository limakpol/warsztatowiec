<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/25/17
 * Time: 12:44 AM
 */

namespace WarehouseBundle\Service\Helper;

use AppBundle\Entity\Good;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use WarehouseBundle\Form\GoodType;

class GoodHelper
{
    private $requestStack;
    private $tokenStorage;
    private $entityManager;
    private $container;
    private $formFactory;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, ContainerInterface $container, FormFactoryInterface $formFactory)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->entityManager    = $entityManager;
        $this->container        = $container;
        $this->formFactory      = $formFactory;
    }

    public function retrieve($sortableParameters)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $goods = $em->getRepository('AppBundle:Good')->retrieve($workshop, $sortableParameters);

        return $goods;
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
                'sortOrder' => 'DESC',
                'sortColumnName' => 'g.updated_at',
                'filterCategoryIds' => [],
                'filterModelIds' => [],
                'filterIndexxIds' => [],
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

        $countAllRetrieved = $em->getRepository('AppBundle:Good')->getCountAllRetrieved($workshop, $inputSortableParameters);

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

    public function getCategories()
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $categories = $em->getRepository('AppBundle:Category')->retrieve($workshop);

        return $categories;
    }

    public function getCategoriesByGoodIds($goodIds = [])
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $categories = $em->getRepository('AppBundle:Category')->retrieveByGoodId($workshop, $goodIds);

        return $categories;
    }

    public function getCarModels()
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $carModels = $em->getRepository('AppBundle:CarModel')->retrieve($workshop);

        return $carModels;
    }

    public function getCarModelsByGoodIds($goodIds = [])
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $carModels = $em->getRepository('AppBundle:CarModel')->retrieveByGoodId($workshop, $goodIds);

        return $carModels;
    }

    public function createEditForm($goodId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $good = $this->entityManager->getRepository('AppBundle:Good')->getOne($workshop, $goodId);

        if(null == $good)
        {
            return null;
        }

        $form = $this->formFactory->create(GoodType::class, $good, [
            'validation_groups' => ['good'],
        ]);

        return $form;
    }

    public function isEditFormValid(Form $form)
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

    public function write(Form $form)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var Good $good */
        $good = $form->getData();

        $good = $this->assignCategories($good);
        $good = $this->assignCarModels($good);

        $em->persist($good);

        $em->flush();

        return $good->getId();
    }

    public function assignCategories(Good $good)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $categories = $good->getCategories()->toArray();

        $good->getCategories()->clear();

        foreach($categories as $categoryId)
        {
            $category = $em->getRepository('AppBundle:Category')->getOne($workshop, $categoryId);

            if(null !== $category)
            {
                $good->addCategory($category);
            }
        }

        return $good;
    }

    public function assignCarModels(Good $good)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $carModels = $good->getCarModels()->toArray();

        $good->getCarModels()->clear();

        foreach($carModels as $carModelId)
        {
            $carModel = $em->getRepository('AppBundle:CarModel')->getOne($workshop, $carModelId);

            if(null !== $carModel)
            {
                $good->addCarModel($carModel);
            }
        }

        return $good;
    }
}