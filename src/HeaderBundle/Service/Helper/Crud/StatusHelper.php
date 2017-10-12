<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/24/17
 * Time: 6:22 AM
 */

namespace HeaderBundle\Service\Helper\Crud;

use AppBundle\Entity\Status;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class StatusHelper
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

        return $request->isMethod('POST')  &&  $request->isXmlHttpRequest();
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

    public function isValid()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        return $request->get('name') != '';
    }

    public function getStatuses()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $statuses = $this
            ->entityManager
            ->getRepository('AppBundle:Status')
            ->retrieve($workshop);

        return $statuses;
    }

    public function getOne()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $id = $request->get('id');

        return $this
            ->entityManager
            ->getRepository('AppBundle:Status')
            ->getOne($workshop, $id);
    }


    public function statusExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $status    = $this
            ->entityManager
            ->getRepository('AppBundle:Status')
            ->getOneByName($workshop, $name)
        ;

        return null !== $status;
    }

    public function statusExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $status = $this
            ->entityManager
            ->getRepository('AppBundle:Status')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $status;
    }

    public function restore(Status $status)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $status->setName($name);

        $status->setDeletedAt(null);
        $status->setRemovedAt(null);
        $status->setRemovedBy(null);
        $status->setDeletedBy(null);
        $status->setUpdatedBy($user);

        $em->persist($status);

        $em->flush();

        return true;
    }

    public function write()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');
        $color      = $request->get('color');

        $status    = new Status();

        $status->setCreatedAt(new \DateTime());
        $status->setCreatedBy($user);
        $status->setUpdatedBy($user);
        $status->setWorkshop($user->getCurrentWorkshop());

        $status->setName($name);
        $status->setHexColor($color);

        $em->persist($status);

        $em->flush();

        return true;
    }

    public function edit(Status $status)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');
        $color      = $request->get('color');

        $status->setName($name);
        $status->setHexColor($color);
        $status->setUpdatedBy($user);

        $em->persist($status);

        $em->flush();

        return true;
    }

    public function remove(Status $status)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $status->setRemovedAt(new \DateTime());
        $status->setRemovedBy($user);
        $status->setUpdatedBy($user);

        $em->persist($status);

        $em->flush();

        return true;
    }

    public function isLast()
    {

        return $this->getStatuses()->count() == 1;
    }

}