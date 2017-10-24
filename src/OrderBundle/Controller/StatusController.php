<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/24/17
 * Time: 3:05 AM
 */

namespace OrderBundle\Controller;


use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\Status;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class StatusController extends Controller
{
    public function getBoxAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $orderHeaderId = $request->get('orderHeaderId');

        /** @var OrderHeader $orderHeader */
        $orderHeader = $em->getRepository('AppBundle:OrderHeader')->getOne($workshop, $orderHeaderId);

        if(null === $orderHeader)
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => ['Nie ma takiego zlecenia'],
            ]);
        }

        $statuses = $em->getRepository('AppBundle:Status')->retrieve($workshop);

        $orderStatuses = $orderHeader->getStatuses()->filter(function(Status $status)
        {
            return null === $status->getRemovedAt() && null === $status->getDeletedAt();
        });

        return $this->render('OrderBundle::status_box_content.html.twig', [
            'statuses' => $statuses,
            'orderStatuses' => $orderStatuses,
            'orderHeaderId' => $orderHeader->getId(),
        ]);
    }

    public function assignAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $orderHeaderId = $request->get('orderHeaderId');

        /** @var OrderHeader $orderHeader */
        $orderHeader = $em->getRepository('AppBundle:OrderHeader')->getOne($workshop, $orderHeaderId);

        if(null === $orderHeader)
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => ['Nie ma takiego zlecenia'],
            ]);
        }

        $orderHeader->getStatuses()->clear();

        $orderStatusIds = $request->get('statusIds');

        if(null !== $orderStatusIds)
        {
            foreach ($orderStatusIds as $orderStatusId)
            {
                $orderStatus = $em->getRepository('AppBundle:Status')->getOne($workshop, $orderStatusId);

                if (null !== $orderStatus)
                {
                    $orderHeader->addStatus($orderStatus);
                }
            }
        }
        $em->persist($orderHeader);

        $em->flush();

        return $this->render('OrderBundle::status_buttons.html.twig', [
            'orderHeader' => $orderHeader,
        ]);
    }
}