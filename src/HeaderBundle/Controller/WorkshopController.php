<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:12 PM
 */

namespace HeaderBundle\Controller;


use AppBundle\Entity\Position;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkshopController extends Controller
{
    public function indexAction()
    {

        /** @var User $user */
        $user = $this->getUser();


        $workshops = $user->getWorkshops()->filter(function(Workshop $workshop)
        {

            return $workshop->getRemovedAt() === null && $workshop->getDeletedAt() === null;
        });

        $positions = $user->getPositions()->filter(function(Position $position) use ($user)
        {
            return $position->getRemovedAt() === null && $position->getDeletedAt() === null;
        });


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


        return $this->render('HeaderBundle::workshop.html.twig', [
            'error'     => null,
            'workshops' => $workshopCollection,
        ]);
    }
}