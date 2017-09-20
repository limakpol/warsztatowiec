<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:24 PM
 */

namespace HeaderBundle\Controller;

use HeaderBundle\Form\UserEditType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    public function indexAction()
    {

        $request = $this->get('request_stack')->getCurrentRequest();

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $form = $this->createForm(UserEditType::class, [
            'user' => $user,
        ]);

        if($request->getMethod() == 'POST' && $request->isXmlHttpRequest() && $request->get('user_edit'))
        {
            $form->handleRequest($request);

            if($form->isValid())
            {
                $em->persist($user);
                $em->flush();

                return new JsonResponse([
                    'error' => 0,
                ]);
            }

            $msg = $form->getErrors(true)->count();
            foreach($form->getErrors(true) as $error)
            {
                $msg = $error->getMessage();
                break;
            }

            return new JsonResponse([
                'error' => 1,
                'msg' => $msg,
            ]);

        }

        return $this->render('HeaderBundle::user.html.twig', [
            'error' => null,
            'form' => $form->createView(),
        ]);
    }

}