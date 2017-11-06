<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/5/17
 * Time: 7:36 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use EmailBundle\Service\Mailer;
use EmailBundle\Service\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WorkshopController extends Controller
{
    public function sendCommentAction()
    {
        /** @var Mailer $mailer */
        $mailer = $this->get('email.mailer');

        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $userName = $user->getForename() . ' ' . $user->getSurname();

        $subject = 'Nowa uwaga użytkownika ' . $userName;

        $path = $request->get('path');

        $body = $this->render('AppBundle:mailing:workshop_comment.html.twig', [
            'comment' => $request->get('comment'),
            'date' => new \DateTime(),
            'userName' => $userName,
            'workshopName' => $workshop->getName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone1(),
            'path' => $path,
        ]);

        $message = new Message();

        $message->setTo('kontakt@warsztatowiec.pl');
        $message->setSubject($subject);
        $message->setBody($body);

        return new JsonResponse($mailer->send($message));
    }
}