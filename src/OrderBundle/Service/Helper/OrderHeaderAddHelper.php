<?php

namespace OrderBundle\Service\Helper;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class OrderHeaderAddHelper
{
    private $tokenStorage;
    private $requestStack;
    private $entityManager;
    private $formFactory;

    public function __construct(TokenStorageInterface $tokenStorage, RequestStack $requestStack, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->tokenStorage     = $tokenStorage;
        $this->requestStack     = $requestStack;
        $this->entityManager    = $entityManager;
        $this->formFactory      = $formFactory;
    }



}