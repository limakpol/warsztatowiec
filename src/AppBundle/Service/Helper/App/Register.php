<?php

namespace AppBundle\Service\Helper\App;

use AppBundle\Entity\Parameters;
use AppBundle\Entity\Settings;
use AppBundle\Entity\User;
use AppBundle\Entity\UserRole;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;

class Register
{

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    public function createFormData()
    {
        return [
            'user' => new User(),
            'workshop' => new Workshop(),
        ];
    }

    private function createRestData()
    {
        return [
            'settings'      => new Settings(),
            'parameters'    => new Parameters(),
            'userRole'      => new UserRole(),
        ];
    }

    public function processForm($formData)
    {
        $restData = $this->createRestData();

        $data = array_merge($formData, $restData);

        $data = $this->setDateTime($data);




    }

    private function setDateTime($data)
    {
        $dateTime = new \DateTime();

        foreach($data as $entity)
        {
            $entity->setCreatedAt($dateTime);
        }

        return $data;
    }



    /*    $em = $this->get('doctrine.orm.default_entity_manager');

    $dateTime = new \DateTime();

    $settings = new Settings();
    $parameters = new Parameters();
    $userRole = new UserRole();

    $settings->setCreatedAt($dateTime);
    $parameters->setCreatedAt($dateTime);
    $workshop->setCreatedAt($dateTime);
    $userRole->setCreatedAt($dateTime);
    $user->setCreatedAt($dateTime);

    $userRole->setUser($user);
    $userRole->setWorkshop($workshop);
    $userRole->setRole(UserRole::ROLE_USER);

    $workshop->setAddress(null);

    $encoder = $this->get('security.password_encoder');

    $password = $encoder->encodePassword($user, $user->getPassword());

    $user->setPassword($password);

    $settings->setWorkshop($workshop);
    $parameters->setWorkshop($workshop);
    $workshop->setOwnerUser($user);
    $user->setCurrentWorkshop($workshop);
    $user->addWorkshop($workshop);

    $em->persist($user);
    $em->persist($workshop);
    $em->persist($parameters);
    $em->persist($settings);
    $em->persist($userRole);

    $em->flush();
*/

}