<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:12 PM
 */

namespace HeaderBundle\Controller;

use AppBundle\Entity\Workshop;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkshopController extends Controller
{
    public function indexAction()
    {
        $workshopIndexHelper = $this->get('header.helper.workshop.index');

        $workshops = $workshopIndexHelper->getWorkshops();

        $positions = $workshopIndexHelper->getPositions();

        $workshopCollection = $workshopIndexHelper->getWorkshopCollection($workshops, $positions);

        return $this->render('HeaderBundle::workshops.html.twig', [
            'error'     => null,
            'workshops' => $workshopCollection,
        ]);
    }

    public function addAction()
    {

        $workshopAddHelper = $this->get('header.helper.workshop.add');

        $form = $workshopAddHelper->createForm();

        if($workshopAddHelper->isRequestCorrect())
        {
            if($workshopAddHelper->isValid($form))
            {
                $workshopAddHelper->write($form);

                return $workshopAddHelper->getSuccessMessage();
            }

            return $workshopAddHelper->getErrors($form);
        }

        return $this->render('HeaderBundle::workshop.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function switchAction()
    {
        $switchHelper = $this->get('header.helper.workshop.switch');

        if(!$switchHelper->isRequestCorrect())
        {
            return $switchHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!(($workshop = $switchHelper->verifyWorkshop()) instanceof Workshop))
        {
            return $switchHelper->getErrorMessage('Warsztat nie istnieje');
        }

        $switchHelper->regenerateToken();

        return $switchHelper->switchWorkshop($workshop);
    }

    public function editAction()
    {
        $workshopEditHelper = $this->get('header.helper.workshop.edit');

        $form = $workshopEditHelper->createForm();

        if($workshopEditHelper->isRequestCorrect())
        {
            if($workshopEditHelper->isValid($form))
            {
                return $workshopEditHelper->write($form);
            }

            return $workshopEditHelper->getErrors($form);
        }

        return $this->render('HeaderBundle::workshop_edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}