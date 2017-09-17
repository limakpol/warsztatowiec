<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/11/17
 * Time: 5:21 PM
 */

namespace AppBundle\Controller;

use AppBundle\Form\LoginType;
use AppBundle\Form\RegistrationType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AppController extends Controller
{

    public function loginAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);

        if($request->getMethod() == 'POST' && $form->isValid())
        {

        }

        return $this->render('AppBundle:homepage:login.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function registerAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        $registerHelper = $this->get('app.helper.app.register');

        $formData = $registerHelper->createFormData();

        $form = $this->createForm(RegistrationType::class, $formData);

        $form->handleRequest($request);

        if($request->getMethod() == 'POST' && $form->isValid())
        {
            $registerHelper->processForm($formData);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('AppBundle:homepage:register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function logoutAction()
    {
        return new Response();
    }

}