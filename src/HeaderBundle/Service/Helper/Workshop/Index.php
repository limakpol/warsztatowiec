<?php

namespace HeaderBundle\Service\Helper\Workshop;

use AppBundle\Entity\Position;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class Index
{

    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function getWorkshops()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $workshops = $user->getWorkshops()->filter(function(Workshop $workshop)
        {

            return $workshop->getRemovedAt() === null && $workshop->getDeletedAt() === null;
        });

        return $workshops;
    }

    public function getPositions()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $positions = $user->getPositions()->filter(function(Position $position) use ($user)
        {
            return $position->getRemovedAt() === null && $position->getDeletedAt() === null;
        });

        return $positions;
    }

    public function getWorkshopCollection(ArrayCollection $workshops, ArrayCollection $positions)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        $workshopCollection = [];

        /** @var Workshop $workshop */
        foreach($workshops as $workshop)
        {
            $positionName   = null;
            $typeOfUser     = 'zwykły';

            /** @var Position $position */
            foreach($positions as $position)
            {
                if($workshop === $position->getWorkshop())
                {
                    $positionName = $position->getName();
                }
            }

            if($user === $workshop->getAdmin())
            {
                $typeOfUser = 'administrator';
            }

            $workshopCollection[] = [$workshop, $positionName, $typeOfUser];
        }

        return $workshopCollection;
    }
}