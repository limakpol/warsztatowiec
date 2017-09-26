<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 2:32 AM
 */

namespace WorkflowBundle\Controller;


use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WorkflowBundle\Form\WorkmanType;

class WorkmanController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WorkflowBundle:workman:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'workflow',
            'navbar'        => 'Pracownicy',
        ]);
    }

    public function addAction()
    {

        /** @var User $user */
        $user = $this->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $newUser = new User();

        $form = $this->createForm(WorkmanType::class, [
            'user' => $newUser,
        ], [
            'validation_groups' => ['workman']
        ]);

        $request = $this->get('request_stack')->getCurrentRequest();

        if($request->isMethod('POST'))
        {
            $form->submit($request->request->get($form->getName()));

            if($form->isValid())
            {
                $em = $this->get('doctrine.orm.default_entity_manager');


                $newUser->setCreatedAt(new \DateTime());
                $newUser->setCreatedBy($user);
                $newUser->setUpdatedBy($user);
                $newUser->addWorkshop($workshop);
                $newUser->setCurrentWorkshop($workshop);

                $em->persist($newUser);
                $em->flush();

                return $this->redirectToRoute('workflow_workman_index');
            }
        }

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WorkflowBundle:workman:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'workflow',
            'navbar'        => 'Dodawanie nowego pracownika',
            'form'          => $form->createView(),
        ]);
    }
}