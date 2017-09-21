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
        $editHelper = $this->get('header.helper.user.edit');

        $form = $editHelper->createForm();

        $user = $form->getData()['user'];

        if($editHelper->isRequestCorrect())
        {
            if($editHelper->isValid($form))
            {
                return $editHelper->write($user);
            }

            return $editHelper->getErrors($form);
        }

        return $this->render('HeaderBundle::user.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}