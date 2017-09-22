<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/22/17
 * Time: 3:02 PM
 */

namespace HeaderBundle\Service\Helper\Workshop;


use AppBundle\Entity\Address;
use AppBundle\Entity\Parameters;
use AppBundle\Entity\Settings;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Helper\App\Register;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use HeaderBundle\Form\WorkshopAddType;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Add
{
    private $formFactory;
    private $requestStack;
    private $tokenStorage;
    private $entityManager;
    private $registerHelper;

    public function __construct(FormFactoryInterface $formFactory, RequestStack $requestStack, TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager, Register $register)
    {
        $this->formFactory      = $formFactory;
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->entityManager    = $entityManager;
        $this->registerHelper   = $register;
    }

    public function createForm()
    {
        $workshop = new Workshop();

        $form = $this->formFactory->create(WorkshopAddType::class, [
            'workshop' => $workshop,
        ], [
            'validation_groups' => 'registration',
        ]);

        return $form;
    }

    public function isRequestCorrect()
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        return
            $request->isMethod('POST')
            &&  $request->isXmlHttpRequest()
            &&  $request->get('workshop_add');
    }

    public function isValid(Form $form)
    {
        $request = $this->requestStack->getCurrentRequest();

        $form->submit($request->request->get($form->getName()), false);

        return $form->isSubmitted() && $form->isValid();
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

    public function write(Form $form)
    {
        /** @var User $user */
        $user       = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop   = $form->getData()['workshop'];

        /** @var EntityManager $em */
        $em         = $this->entityManager;

        $dateTime   = new \DateTime();

        $parameters     = new Parameters();
        $settings       = new Settings();
        $address        = new Address();

        $settings   ->setCreatedAt($dateTime)
                    ->setCreatedBy($user)
                    ->setUpdatedBy($user)
                    ->setWorkshop($workshop);
        $parameters ->setCreatedAt($dateTime)
                    ->setCreatedBy($user)
                    ->setUpdatedBy($user)
                    ->setWorkshop($workshop);
        $workshop   ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $address    ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        
        $workshop   ->setAddress($address)->setAdmin($user);
        
        $user->addWorkshop($workshop);
        
        $em->persist($user);
        $em->persist($workshop);
        $em->persist($parameters);
        $em->persist($settings);
        
        $em->flush();

        $this->registerHelper->assignRoles($workshop, $workshop->getAdmin());
        $this->registerHelper->assignMeasures($workshop);
        $this->registerHelper->assignWorkstations($workshop);
        $this->registerHelper->assignPositions($workshop, $workshop->getAdmin());
        $this->registerHelper->assignStatuses($workshop);
        $this->registerHelper->assignActions($workshop);
        
        return true;
    }

    public function getSuccessMessage()
    {
        return new JsonResponse([
            'error' => 0,
        ]);
    }
}