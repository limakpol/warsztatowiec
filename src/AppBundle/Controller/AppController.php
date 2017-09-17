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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class AppController extends Controller
{

    public function loginAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY'))
        {
            return $this->redirect($this->generateUrl('customer_index'));
        }

        /** @var AuthenticationUtils $authenticationUtils */
        $authenticationUtils = $this->get('security.authentication_utils');

        $lastLogin = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class);

        return  $this->render('AppBundle:homepage:login.html.twig', [
            'lastLogin' => $lastLogin,
            'form'=> $form->createView(),
            'isError' => null !== $authenticationUtils->getLastAuthenticationError(),
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