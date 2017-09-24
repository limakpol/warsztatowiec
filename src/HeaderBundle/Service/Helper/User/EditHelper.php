<?php

namespace HeaderBundle\Service\Helper\User;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use HeaderBundle\Form\UserEditType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class EditHelper
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

        $user = $token->getUser();

        $formFactory = $this->formFactory;

        return $form = $formFactory->create(UserEditType::class, [
            'user' => $user,
        ], [
            'validation_groups' => 'user',
        ]);
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
        &&  $request->get('user_edit');
    }

    public function write(Form $form)
    {
        /** @var User $user */
        $user = $form->getData()['user'];

        $user->setUpdatedBy($user);
        $this->entityManager->persist($user);
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
}