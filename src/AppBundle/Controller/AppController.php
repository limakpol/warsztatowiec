<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/11/17
 * Time: 5:21 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\UserRole;
use AppBundle\Entity\Parameters;
use AppBundle\Entity\Settings;
use AppBundle\Entity\Workshop;
use AppBundle\Form\LoginType;
use AppBundle\Form\RegistrationType;
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

       // $settings = new Settings();
        //$parameters = new Parameters();
        $workshop = new Workshop();
        //$userRole = new UserRole();
        $user = new User();

        //$settings->setWorkshop($workshop);
        //$parameters->setWorkshop($workshop);
       // $workshop->setOwnerUser($user);
        //$user->setCurrentWorkshop($workshop);
        //$user->addWorkshop($workshop);


        $form = $this->createForm(RegistrationType::class, [
            'user' => $user,
            'workshop' => $workshop,
        ]);
        $form->handleRequest($request);

        if($request->getMethod() == 'POST' && $form->isValid())
        {
            $em = $this->get('doctrine.orm.default_entity_manager');

            $dateTime = new \DateTime();

            $settings = new Settings();
            $parameters = new Parameters();
            $userRole = new UserRole();

            $settings->setCreatedAt($dateTime);
            $parameters->setCreatedAt($dateTime);
            $workshop->setCreatedAt($dateTime);
            $userRole->setCreatedAt($dateTime);
            $user->setCreatedAt($dateTime);

            $userRole->setUser($user);
            $userRole->setWorkshop($workshop);
            $userRole->setRole(UserRole::ROLE_USER);

            $workshop->setAddress(null);

            $encoder = $this->get('security.password_encoder');

            $password = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($password);

            $settings->setWorkshop($workshop);
            $parameters->setWorkshop($workshop);
            $workshop->setOwnerUser($user);
            $user->setCurrentWorkshop($workshop);
            $user->addWorkshop($workshop);

            $em->persist($user);
            $em->persist($workshop);
            $em->persist($parameters);
            $em->persist($settings);
            $em->persist($userRole);

            $em->flush();

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