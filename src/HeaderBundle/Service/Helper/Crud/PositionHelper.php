<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/24/17
 * Time: 6:22 AM
 */

namespace HeaderBundle\Service\Helper\Crud;

use AppBundle\Entity\Position;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PositionHelper
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

    public function getPositions()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $positions = $this
            ->entityManager
            ->getRepository('AppBundle:Position')
            ->retrieve($workshop);

        return $positions;
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
            ->getRepository('AppBundle:Position')
            ->getOne($workshop, $id);
    }


    public function positionExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $position    = $this
            ->entityManager
            ->getRepository('AppBundle:Position')
            ->getOneByName($workshop, $name)
        ;

        return null !== $position;
    }

    public function positionExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $position = $this
            ->entityManager
            ->getRepository('AppBundle:Position')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $position;
    }

    public function restore(Position $position)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $position->setName($name);

        $position->setDeletedAt(null);
        $position->setRemovedAt(null);
        $position->setRemovedBy(null);
        $position->setDeletedBy(null);
        $position->setUpdatedBy($user);

        $em->persist($position);

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

        $position    = new Position();

        $position->setCreatedAt(new \DateTime());
        $position->setCreatedBy($user);
        $position->setUpdatedBy($user);
        $position->setWorkshop($user->getCurrentWorkshop());

        $position->setName($name);

        $em->persist($position);

        $em->flush();

        return true;
    }

    public function edit(Position $position)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $position->setName($name);
        $position->setUpdatedBy($user);

        $em->persist($position);

        $em->flush();

        return true;
    }

    public function remove(Position $position)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $position->setRemovedAt(new \DateTime());
        $position->setRemovedBy($user);
        $position->setUpdatedBy($user);

        $em->persist($position);

        $em->flush();

        return true;
    }

    public function isLast()
    {

        return $this->getPositions()->count() == 1;
    }

}