<?php

namespace AppBundle\Service\Helper\App;

use AppBundle\Entity\Action;
use AppBundle\Entity\Address;
use AppBundle\Entity\CarBrand;
use AppBundle\Entity\CarModel;
use AppBundle\Entity\Measure;
use AppBundle\Entity\Parameters;
use AppBundle\Entity\Position;
use AppBundle\Entity\Producer;
use AppBundle\Entity\Settings;
use AppBundle\Entity\Status;
use AppBundle\Entity\User;
use AppBundle\Entity\UserRole;
use AppBundle\Entity\Workshop;
use AppBundle\Entity\Workstation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Register
{

    private $em;
    private $encoder;
    private $container;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder, ContainerInterface $container)
    {
        $this->em           = $entityManager;
        $this->encoder      = $encoder;
        $this->container    = $container;
    }

    public function createFormData()
    {
        return [
            'user' => new User(),
            'workshop' => new Workshop(),
        ];
    }

    public function processForm($formData)
    {
        /** @var Workshop $workshop */
        $workshop   = $formData['workshop'];

        /** @var User $user */
        $user       = $formData['user'];

        /** @var EntityManagerInterface $em */
        $em = $this->em;

        $settings           = new Settings();
        $parameters         = new Parameters();
        $userAddress        = new Address();
        $workshopAddress    = new Address();
        $dateTime           = new \DateTime();

        $settings   ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $parameters ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $workshop   ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $user       ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $userAddress->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $workshopAddress->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);

        $user->setAddress($userAddress);
        $workshop->setAddress($workshopAddress);

        $password = $this->encoder->encodePassword($user, $user->getPassword());
        $user       ->setPassword($password);

        $settings   ->setWorkshop($workshop);
        $parameters ->setWorkshop($workshop);
        $workshop   ->setAdmin($user);
        $user       ->setCurrentWorkshop($workshop);
        $user       ->addWorkshop($workshop);

        $em->persist($user);
        $em->persist($workshop);
        $em->persist($parameters);
        $em->persist($settings);

        $this->assignRoles($workshop, $workshop->getAdmin());
        $this->assignMeasures($workshop);
        $this->assignWorkstations($workshop);
        $this->assignPositions($workshop, $workshop->getAdmin());
        $this->assignStatuses($workshop);
        $this->assignProducers($workshop);
        $this->assignActions($workshop);
        $this->assignCarModels($workshop);

        $em->flush();

        return;
    }

    public function assignMeasures(Workshop $workshop)
    {
        /** @var EntityManager $em */
        $em = $this->em;

        /** @var User $user */
        $user = $workshop->getAdmin();

        $dateTime = new \DateTime();

        $measures = $this->container->getParameter('app')['measures'];

        $goodMeasures       = $measures['good'];
        $serviceMeasures    = $measures['service'];

        foreach($goodMeasures as $goodMeasure)
        {
            $measure = new Measure();
            $measure->setWorkshop($workshop);
            $measure->setName($goodMeasure[0]);
            $measure->setShortcut($goodMeasure[1]);
            $measure->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
            $measure->setTypeOfQuantity('good');

            $em->persist($measure);
        }

        foreach($serviceMeasures as $serviceMeasure)
        {
            $measure = new Measure();
            $measure->setWorkshop($workshop);
            $measure->setName($serviceMeasure[0]);
            $measure->setShortcut($serviceMeasure[1]);
            $measure->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
            $measure->setTypeOfQuantity('service');

            $em->persist($measure);
        }

       // $em->flush();

        return true;
    }

    public function assignWorkstations(Workshop $workshop)
    {
        /** @var EntityManager $em */
        $em = $this->em;

        /** @var User $user */
        $user = $workshop->getAdmin();

        $dateTime = new \DateTime();

        $workstations = $this->container->getParameter('app')['workstations'];

        foreach($workstations as $workstationName)
        {
            $workstation = new Workstation();
            $workstation->setWorkshop($workshop);
            $workstation->setName($workstationName);
            $workstation->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);

            $em->persist($workstation);
        }

        //$em->flush();

        return true;
    }

    public function assignPositions(Workshop $workshop, User $user)
    {
        /** @var EntityManager $em */
        $em = $this->em;

        $dateTime = new \DateTime();

        $positions = $this->container->getParameter('app')['positions'];

        foreach($positions as $positionName)
        {
            $position = new Position();
            $position->setWorkshop($workshop);
            $position->setName($positionName);
            $position->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);

            $em->persist($position);

            if($user->getPositions()->filter(function(Position $position) use ($workshop)
                {
                    return $position->getWorkshop() === $workshop;
                })->count() == 0)
            {
                $user->addPosition($position);

                $em->persist($user);
            }
        }

        //$em->flush();

        return true;
    }

    public function assignStatuses(Workshop $workshop)
    {
        /** @var EntityManager $em */
        $em = $this->em;

        /** @var User $user */
        $user = $workshop->getAdmin();

        $dateTime = new \DateTime();

        $statuses = $this->container->getParameter('app')['statuses'];

        foreach($statuses as $statusSet)
        {
            $status = new Status();
            $status->setWorkshop($workshop);
            $status->setName($statusSet[0]);
            $status->setHexColor($statusSet[1]);
            $status->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);

            $em->persist($status);
        }

        //$em->flush();

        return true;
    }

    public function assignProducers(Workshop $workshop)
    {
        /** @var EntityManager $em */
        $em = $this->em;

        /** @var User $user */
        $user = $workshop->getAdmin();

        $dateTime = new \DateTime();

        $producers = $this->container->getParameter('app')['producers'];

        foreach($producers as $producerName)
        {
            $producer = new Producer();
            $producer->setWorkshop($workshop);
            $producer->setName($producerName);
            $producer->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);

            $em->persist($producer);
        }

        //$em->flush();

        return true;
    }

    public function assignActions(Workshop $workshop)
    {
        /** @var EntityManager $em */
        $em = $this->em;

        /** @var User $user */
        $user = $workshop->getAdmin();

        $dateTime = new \DateTime();

        $actions = $this->container->getParameter('app')['actions'];

        foreach($actions as $actionName)
        {
            $action = new Action();
            $action->setWorkshop($workshop);
            $action->setName($actionName);
            $action->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);

            $em->persist($action);
        }

        //$em->flush();

        return true;
    }

    public function assignRoles(Workshop $workshop, User $user)
    {
        /** @var EntityManager $em */
        $em = $this->em;

        $dateTime = new \DateTime();

        $roleNames = [
            UserRole::ROLE_USER,
            UserRole::ROLE_TESTER,
            UserRole::ROLE_ADMIN,
            UserRole::ROLE_DEVELOPER
        ];

        foreach($roleNames as $roleName)
        {
            $userRole = new UserRole();
            $userRole
                ->setCreatedAt($dateTime)
                ->setCreatedBy($user)
                ->setUpdatedBy($user)
                ->setRole($roleName)
                ->setUser($user)
                ->setWorkshop($workshop)
            ;

            $em->persist($userRole);
        }

        //$em->flush();
    }

    public function assignCarModels(Workshop $workshop)
    {
        /** @var EntityManager $em */
        $em = $this->em;

        /** @var User $user */
        $user = $workshop->getAdmin();

        $dateTime = new \DateTime();

        $carModels = $this->container->getParameter('app')['car_models'];

        foreach($carModels as $carModelData)
        {
            $carBrand = new CarBrand();
            $carBrand->setWorkshop($workshop);
            $carBrand->setName($carModelData['brand']);
            $carBrand->setCreatedAt($dateTime);
            $carBrand->setCreatedBy($workshop->getAdmin());
            $carBrand->setUpdatedBy($workshop->getAdmin());

            foreach($carModelData['models'] as $modelName)
            {
                $carModel = new CarModel();
                $carModel->setBrand($carBrand);
                $carModel->setName($modelName);
                $carModel->setCreatedAt($dateTime);
                $carModel->setCreatedBy($workshop->getAdmin());
                $carModel->setUpdatedBy($workshop->getAdmin());

                $em->persist($carModel);
            }

            $em->persist($carBrand);
        }

        //$em->flush();

        return true;
    }
}