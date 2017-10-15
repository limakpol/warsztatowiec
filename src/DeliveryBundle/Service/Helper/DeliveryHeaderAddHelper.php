<?php

namespace DeliveryBundle\Service\Helper;

use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use CustomerBundle\Service\Helper\CustomerIndexHelper;
use DeliveryBundle\Form\DeliveryHeaderAddType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DeliveryHeaderAddHelper
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

    public function createForm()
    {
        $form = $this->formFactory->create(DeliveryHeaderAddType::class);

        return $form;
    }

}