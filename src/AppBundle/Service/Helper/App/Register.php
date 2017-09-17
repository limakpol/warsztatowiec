<?php

namespace AppBundle\Service\Helper\App;

use AppBundle\Entity\Parameters;
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
        $workshop   = $formData['workshop'];
        $user       = $formData['user'];
        
        $settings   = new Settings();
        $parameters = new Parameters();
        $userRole   = new UserRole();
        
        $dateTime   = new \DateTime();

        $settings   = new Settings();
        $parameters = new Parameters();
        $userRole   = new UserRole();

        $settings   ->setCreatedAt($dateTime);
        $parameters ->setCreatedAt($dateTime);
        $workshop   ->setCreatedAt($dateTime);
        $userRole   ->setCreatedAt($dateTime);
        $user       ->setCreatedAt($dateTime);

        $userRole   ->setUser($user);
        $userRole   ->setWorkshop($workshop);
        $userRole   ->setRole(UserRole::ROLE_USER);

        $workshop->setAddress(null);

        $password = $this->encoder->encodePassword($user, $user->getPassword());
        $user     ->setPassword($password);

        $settings   ->setWorkshop($workshop);
        $parameters ->setWorkshop($workshop);
        $workshop   ->setOwnerUser($user);
        $user       ->setCurrentWorkshop($workshop);
        $user       ->addWorkshop($workshop);

        $this->em->persist($user);
        $this->em->persist($workshop);
        $this->em->persist($parameters);
        $this->em->persist($settings);
        $this->em->persist($userRole);

        $this->em->flush();      

    }
}