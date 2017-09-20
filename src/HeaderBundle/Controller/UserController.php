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

class UserController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();

        $form = $this->createForm(UserEditType::class, [
            'user' => $user,
        ]);

        return $this->render('HeaderBundle::user.html.twig', [
            'error' => null,
            'form' => $form->createView(),
        ]);
    }


}