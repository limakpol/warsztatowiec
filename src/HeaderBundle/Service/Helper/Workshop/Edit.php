<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/22/17
 * Time: 7:45 PM
 */

namespace HeaderBundle\Service\Helper\Workshop;


use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;
use HeaderBundle\Form\WorkshopEditType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Edit
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
        /** @var TokenStorage $token */
        $token = $this->tokenStorage->getToken();

        /** @var User $user */
        $user = $token->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $formFactory = $this->formFactory;

        return $form = $formFactory->create(WorkshopEditType::class, [
            'workshop' => $workshop,
        ], [
            'validation_groups' => 'workshop_edit',
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
            &&  $request->get('workshop_edit');
    }

    public function write(Form $form)
    {
        /** @var Workshop $workshop */
        $workshop = $form->getData()['workshop'];

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $workshop->setUpdatedBy($user);

        $this->entityManager->persist($workshop);
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
