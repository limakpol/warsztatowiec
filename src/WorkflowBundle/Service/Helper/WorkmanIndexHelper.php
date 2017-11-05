<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/23/17
 * Time: 7:41 PM
 */

namespace WorkflowBundle\Service\Helper;

use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class WorkmanIndexHelper
{
    private $requestStack;
    private $tokenStorage;
    private $formFactory;
    private $entityManager;
    private $container;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->formFactory      = $formFactory;
        $this->entityManager    = $entityManager;
        $this->container        = $container;
    }

    public function retrieve($sortableParameters = [])
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        if(!$sortableParameters)
        {
            $sortableParameters = $this->getSortableParameters();
        }

        $users = $em->getRepository('AppBundle:User')->retrieve($workshop, $sortableParameters);

        return $users;
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
                'limit' => 500,
                'currentPage' => 1,
                'requestedPage' => 1,
                'sortOrder' => 'DESC',
                'sortColumnName' => 'u.created_at',
                'systemFilters' => [],
                'customFilters' => [],
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

        $countAllRetrieved = $em->getRepository('AppBundle:User')->getCountAllRetrieved($workshop, $inputSortableParameters);

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

    public function getSortableParameters()
    {
        $inputSortableParameters = $this->getInputSortableParameters();
        $outputSortableParameters = $this->getOutputSortableParameters($inputSortableParameters);

        return array_merge($inputSortableParameters, $outputSortableParameters);
    }

}