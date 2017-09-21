<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:15 PM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PasswordController extends Controller
{
    public function changeAction()
    {
        $passwordChangeHelper = $this->get('header.helper.password.change');

        $form = $passwordChangeHelper->createForm();

        if($passwordChangeHelper->isRequestCorrect())
        {
            if(!$passwordChangeHelper->checkCurrentPassword())
            {
                return $passwordChangeHelper->getError('Wpisane Aktualne hasło jest nieprawidłowe');
            }

            if(!$passwordChangeHelper->checkNewPassword())
            {
                return $passwordChangeHelper->getError('Wpisane nowe hasło różni się od powtórzonego');
            }

            if($passwordChangeHelper->isValid($form))
            {
                return $passwordChangeHelper->write($form);
            }

            return $passwordChangeHelper->getFormErrors($form);
        }

        return $this->render('HeaderBundle::password.html.twig', [
            'error' => null,
            'form'  => $form->createView(),
        ]);
    }
}