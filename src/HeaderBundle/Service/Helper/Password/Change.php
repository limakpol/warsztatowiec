<?php

namespace HeaderBundle\Service\Helper\Password;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use HeaderBundle\Form\ChangePasswordType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Change
{
    private $currentRequest;
    private $formFactory;
    private $em;
    private $encoder;
    private $tokenStorage;

    public function __construct(RequestStack $requestStack, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, TokenStorageInterface $tokenStorage)
    {
        $this->currentRequest   = $requestStack->getCurrentRequest();
        $this->formFactory      = $formFactory;
        $this->em               = $entityManager;
        $this->encoder          = $encoder;
        $this->tokenStorage     = $tokenStorage;
    }

    public function createForm()
    {
        $formFactory = $this->formFactory;

        return $form = $formFactory->create(ChangePasswordType::class);
    }

    public function isRequestCorrect()
    {
        /** @var Request $request */
        $request = $this->currentRequest;

        return
            $request->isMethod('POST')
            &&  $request->isXmlHttpRequest()
            &&  $request->get('change_password');
    }

    public function checkCurrentPassword()
    {
        $user = $this->tokenStorage->getToken()->getUser();

        $requestData =  $this->currentRequest->get('change_password');

        $password = $requestData['current_password'];

        return $this->encoder->isPasswordValid($user, $password);
    }

    public function checkNewPassword()
    {
        $requestData = $this->currentRequest->get('change_password');

        return $requestData['new_password'] == $requestData['new_password_repeat'];
    }

    public function isValid(Form $form)
    {
        $request = $this->currentRequest->request;

        $form->submit($request->get($form->getName()), false);

        return $form->isSubmitted() && $form->isValid();
    }

    public function getFormErrors(Form $form)
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

    public function getError($message)
    {
        return new JsonResponse([
            'error' => 1,
            'messages' => [$message],
        ]);
    }

    public function write(Form $form)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $formData = $form->getData();

        $password = $this->encoder->encodePassword($user, $formData['new_password']);

        $user->setPassword($password);
        $user->setUpdatedBy($user);

        $this->em->persist($user);

        $this->em->flush();

        return new JsonResponse([
            'error' => 0,
        ]);
    }
}