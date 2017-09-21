<?php

namespace AppBundle\Service\Helper\App;

use AppBundle\Entity\Address;
use AppBundle\Entity\Parameters;
use AppBundle\Entity\Position;
use AppBundle\Entity\Settings;
use AppBundle\Entity\User;
use AppBundle\Entity\UserRole;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Register
{

    protected $em;
    protected $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder)
    {
        $this->em       = $entityManager;
        $this->encoder  = $encoder;
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
        $position           = new Position();
        $dateTime           = new \DateTime();
        
        $settings   ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $parameters ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $workshop   ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $user       ->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $userAddress->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $workshopAddress->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user);
        $position->setCreatedAt($dateTime)->setCreatedBy($user)->setUpdatedBy($user)->setName('administrator aplikacji')->setWorkshop($workshop);
        $user->addPosition($position);

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

        $user->setAddress($userAddress);
        $workshop->setAddress($workshopAddress);

        $password = $this->encoder->encodePassword($user, $user->getPassword());
        $user       ->setPassword($password);

        $settings   ->setWorkshop($workshop);
        $parameters ->setWorkshop($workshop);
        $workshop   ->setAdmin($user);
        $user       ->setCurrentWorkshop($workshop);
        $user       ->addWorkshop($workshop);

        $em->persist($position);
        $em->persist($user);
        $em->persist($workshop);
        $em->persist($parameters);
        $em->persist($settings);

        $em->flush();
    }
}