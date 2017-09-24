<?php

namespace HeaderBundle\Service\Helper\Parameters;

use AppBundle\Entity\Parameters;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;
use HeaderBundle\Form\ParametersType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Index
{
    private $requestStack;
    private $entityManager;
    private $tokenStorage;
    private $formFactory;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage, FormFactoryInterface $formFactory)
    {
        $this->requestStack     = $requestStack;
        $this->entityManager    = $entityManager;
        $this->tokenStorage     = $tokenStorage;
        $this->formFactory      = $formFactory;
    }

    public function createForm()
    {
        $token = $this->tokenStorage->getToken();

        /** @var User $user */
        $user = $token->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var Parameters $parameters */
        $parameters = $workshop->getParameters();

        $formFactory = $this->formFactory;

        return $form = $formFactory->create(ParametersType::class, $parameters);
    }

    public function isValid(Form $form)
    {
        $request = $this->requestStack->getCurrentRequest();

        $form->submit($request->request->get($form->getName()), false);

        return $form->isSubmitted() && $form->isValid();
    }

    public function isRequestCorrect()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        return
            $request->isMethod('POST')
            &&  $request->isXmlHttpRequest()
            &&  $request->get('parameters');
    }

    public function write(Form $form)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Parameters $parameters */
        $parameters = $form->getData();

        $parameters->setUpdatedBy($user);

        $this->entityManager->persist($parameters);

        $this->entityManager->flush();

        return new JsonResponse([
            'error' => 0,
        ]);
    }

    public function getErrors(Form $form)
    {
        $messages = [];

        foreach($form->getErrors(true) as $error)
        {
            $messages[] = $error->getMessage();
        }

        return new JsonResponse([
            'error'     => 1,
            'messages'  => $messages,
        ]);
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

}