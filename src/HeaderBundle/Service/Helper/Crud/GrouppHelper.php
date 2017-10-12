<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/24/17
 * Time: 6:22 AM
 */

namespace HeaderBundle\Service\Helper\Crud;

use AppBundle\Entity\Groupp;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class GrouppHelper
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

    public function getGroupps()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $groupps = $this
            ->entityManager
            ->getRepository('AppBundle:Groupp')
            ->retrieve($workshop);

        return $groupps;
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
            ->getRepository('AppBundle:Groupp')
            ->getOne($workshop, $id);
    }


    public function grouppExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $groupp    = $this
            ->entityManager
            ->getRepository('AppBundle:Groupp')
            ->getOneByName($workshop, $name)
        ;

        return null !== $groupp;
    }

    public function grouppExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');

        $groupp = $this
            ->entityManager
            ->getRepository('AppBundle:Groupp')
            ->getOneRemovedByName($workshop, $name)
        ;

        return $groupp;
    }

    public function restore(Groupp $groupp)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $groupp->setName($name);

        $groupp->setDeletedAt(null);
        $groupp->setRemovedAt(null);
        $groupp->setRemovedBy(null);
        $groupp->setDeletedBy(null);
        $groupp->setUpdatedBy($user);

        $em->persist($groupp);

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

        $groupp    = new Groupp();

        $groupp->setCreatedAt(new \DateTime());
        $groupp->setCreatedBy($user);
        $groupp->setUpdatedBy($user);
        $groupp->setWorkshop($user->getCurrentWorkshop());

        $groupp->setName($name);

        $em->persist($groupp);

        $em->flush();

        return true;
    }

    public function edit(Groupp $groupp)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');

        $groupp->setName($name);
        $groupp->setUpdatedBy($user);

        $em->persist($groupp);

        $em->flush();

        return true;
    }

    public function remove(Groupp $groupp)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $groupp->setRemovedAt(new \DateTime());
        $groupp->setRemovedBy($user);
        $groupp->setUpdatedBy($user);

        $em->persist($groupp);

        $em->flush();

        return true;
    }

    public function isLast()
    {

        return $this->getGroupps()->count() == 1;
    }

}