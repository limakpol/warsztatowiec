<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:24 PM
 */

namespace HeaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function editAction()
    {
        $userEditHelper = $this->get('header.helper.user.edit');

        $form = $userEditHelper->createForm();

        $user = $form->getData()['user'];

        if($userEditHelper->isRequestCorrect())
        {
            if($userEditHelper->isValid($form))
            {
                return $userEditHelper->write($user);
            }

            return $userEditHelper->getErrors($form);
        }

        return $this->render('HeaderBundle::user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}