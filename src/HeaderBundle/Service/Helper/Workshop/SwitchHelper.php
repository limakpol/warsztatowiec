<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/22/17
 * Time: 6:21 PM
 */

namespace HeaderBundle\Service\Helper\Workshop;

use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SwitchHelper
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

        return
            $request->isMethod('POST')
            &&  $request->isXmlHttpRequest()
            &&  $request->get('id');
    }

    public function verifyWorkshop()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $id = $request->get('id');

        $workshop = $em->getRepository('AppBundle:Workshop')->getOne($id);

        return (null !== $workshop && $user->getWorkshops()->contains($workshop)) ? $workshop : false;
    }

    public function switchWorkshop(Workshop $workshop)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $user->setCurrentWorkshop($workshop);

        $em->persist($user);

        $em->flush();

        return $this->getSuccessMessage();
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

    public function regenerateToken()
    {
        /** @var TokenInterface $token */
        $token = $this->tokenStorage->getToken();

        /** @var User $user */
        $user = $token->getUser();

        $token = new UsernamePasswordToken(
            $user,
            $user->getPassword(),
            'my_provider',
            $user->getRoles()
        );

        $this->tokenStorage->setToken($token);

        return;
    }
}
