<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/24/17
 * Time: 6:21 AM
 */

namespace HeaderBundle\Service\Helper\Crud;

use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Entity\Workstation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class WorkstationHelper
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

    public function getWorkstations()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $workstations = $this
            ->entityManager
            ->getRepository('AppBundle:Workstation')
            ->retrieve($workshop);

        return $workstations;
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
            ->getRepository('AppBundle:Workstation')
            ->getOne($workshop, $id);
    }


    public function workstationExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $workstation    = $this
            ->entityManager
            ->getRepository('AppBundle:Workstation')
            ->getOneByName($workshop, $name)
        ;

        return null !== $workstation;
    }



    public function workstationExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $workstation = $this
            ->entityManager
            ->getRepository('AppBundle:Workstation')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $workstation;
    }

    public function recover(Workstation $workstation)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $workstation->setName($name);

        $workstation->setDeletedAt(null);
        $workstation->setRemovedAt(null);
        $workstation->setRemovedBy(null);
        $workstation->setDeletedBy(null);
        $workstation->setUpdatedBy($user);

        $em->persist($workstation);

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

        $workstation    = new Workstation();

        $workstation->setCreatedAt(new \DateTime());
        $workstation->setCreatedBy($user);
        $workstation->setUpdatedBy($user);
        $workstation->setWorkshop($user->getCurrentWorkshop());

        $workstation->setName($name);

        $em->persist($workstation);

        $em->flush();

        return true;
    }

    public function edit(Workstation $workstation)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $workstation->setName($name);
        $workstation->setUpdatedBy($user);

        $em->persist($workstation);

        $em->flush();

        return true;
    }

    public function remove(Workstation $workstation)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $workstation->setRemovedAt(new \DateTime());
        $workstation->setRemovedBy($user);
        $workstation->setUpdatedBy($user);

        $em->persist($workstation);

        $em->flush();

        return true;
    }

    public function isLast()
    {

        return $this->getWorkstations()->count() == 1;
    }


}