<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/11/17
 * Time: 5:21 PM
 */

namespace AppBundle\Controller;


use AppBundle\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AppController extends Controller
{

    public function loginAction()
    {

        return $this->render('AppBundle:app:login.html.twig');
    }

    public function registerAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        $form = $this->createForm(RegistrationType::class);
        $form->handleRequest($request);

        if($request->getMethod() == 'POST' && $form->isValid())
        {

        }

        return $this->render('AppBundle:app:register.html.twig');
    }

    public function logoutAction()
    {
        return $this->render('AppBundle:app:login.html.twig');
    }

}