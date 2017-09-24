<?php

namespace HeaderBundle\Service\Helper\Crud;


use AppBundle\Entity\Measure;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MeasureHelper
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

        return  $request->get('type')       != ''
            &&  $request->get('name')       != ''
            &&  $request->get('shortcut')   != '';
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
                    ->getRepository('AppBundle:Measure')
                    ->getOne($workshop, $id);
    }


    public function measureExists()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');
        $shortcut   = $request->get('shortcut');
        $type       = $request->get('type');

        $measure = $this
                    ->entityManager
                    ->getRepository('AppBundle:Measure')
                    ->getOneByData($workshop, $name, $shortcut, $type)
            ;

        return null !== $measure;
    }

    public function measureExistsRemoved()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $name       = $request->get('name');
        $shortcut   = $request->get('shortcut');
        $type       = $request->get('type');

        $measure = $this
            ->entityManager
            ->getRepository('AppBundle:Measure')
            ->getOneRemovedByData($workshop, $name, $shortcut, $type)
        ;

        return $measure;
    }

    public function recover(Measure $measure)
    {
        /** @var Request $request */
        $request    = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');
        $shortcut   = $request->get('shortcut');

        $measure->setName($name);
        $measure->setShortcut($shortcut);

        $measure->setDeletedAt(null);
        $measure->setRemovedAt(null);
        $measure->setRemovedBy(null);
        $measure->setDeletedBy(null);
        $measure->setUpdatedBy($user);

        $em->persist($measure);

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
        $shortcut   = $request->get('shortcut');
        $type       = $request->get('type');

        $measure    = new Measure();

        $measure->setCreatedAt(new \DateTime());
        $measure->setCreatedBy($user);
        $measure->setUpdatedBy($user);
        $measure->setWorkshop($user->getCurrentWorkshop());

        $measure->setName($name);
        $measure->setShortcut($shortcut);
        $measure->setTypeOfQuantity($type);

        $em->persist($measure);

        $em->flush();

        return true;
    }

    public function edit(Measure $measure)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $name       = $request->get('name');
        $shortcut   = $request->get('shortcut');

        $measure->setName($name);
        $measure->setShortcut($shortcut);
        $measure->setUpdatedBy($user);

        $em->persist($measure);

        $em->flush();

        return true;
    }

    public function remove(Measure $measure)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $measure->setRemovedAt(new \DateTime());
        $measure->setRemovedBy($user);
        $measure->setUpdatedBy($user);

        $em->persist($measure);

        $em->flush();

        return true;
    }

    public function isLast(Measure $measure)
    {
        $type = $measure->getTypeOfQuantity();

        return $this->getMeasures($type)->count() == 1;
    }

    public function getMeasures($type)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $meaures = $workshop->getMeasures()->filter(function(Measure $measure) use ($type)
        {
            return  $measure->getRemovedAt()        === null
            &&      $measure->getDeletedAt()        === null
            &&      $measure->getTypeOfQuantity()   == $type;
        });

        return $meaures;
    }

}