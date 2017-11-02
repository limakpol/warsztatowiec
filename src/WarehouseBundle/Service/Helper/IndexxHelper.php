<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/25/17
 * Time: 12:44 AM
 */

namespace WarehouseBundle\Service\Helper;

use AppBundle\Entity\Indexx;
use AppBundle\Entity\IndexxEdit;
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
use WarehouseBundle\Form\IndexxEditType;

class IndexxHelper
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

        $goods = $em->getRepository('AppBundle:Indexx')->retrieve($workshop, $sortableParameters);

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
                'sortColumnName' => 'i.updated_at',
                'filterGoodIds' => [],
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

        $countAllRetrieved = $em->getRepository('AppBundle:Indexx')->getCountAllRetrieved($workshop, $inputSortableParameters);

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

    public function setIndexxEdit(Indexx $indexx, $prevIndexxQty)
    {

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $diffQty = round($indexx->getQuantity() - $prevIndexxQty, 2);

        $indexxEdit = new IndexxEdit();
        $indexxEdit->setCreatedAt(new \DateTime());
        $indexxEdit->setCreatedBy($user);
        $indexxEdit->setWorkshop($workshop);
        $indexxEdit->setIndexx($indexx);
        $indexxEdit->setBeforeQty($prevIndexxQty);
        $indexxEdit->setAfterQty($indexx->getQuantity());
        $indexxEdit->setChangeQty($diffQty);

        $em->persist($indexxEdit);

        return;
    }

    public function createEditForm($indexxId)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var Indexx $indexx */
        $indexx = $this->entityManager->getRepository('AppBundle:Indexx')->getOne($workshop, $indexxId);

        if(null === $indexx)
        {
            return null;
        }

        $prevIndexxQty = $indexx->getQuantity();

        $form = $this->formFactory->create(IndexxEditType::class, $indexx, [
            'validation_groups' => ['indexx', 'indexx_edit'],
        ]);

        return [$form, $prevIndexxQty];
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

    public function write(Form $form, $prevIndexxQty)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var Indexx $indexx */
        $indexx = $form->getData();

        if($indexx->getQuantity() != $prevIndexxQty)
        {
            $this->setIndexxEdit($indexx, $prevIndexxQty);
        }

        $em->persist($indexx);

        $em->flush();

        return $indexx->getGoodId();
    }

}