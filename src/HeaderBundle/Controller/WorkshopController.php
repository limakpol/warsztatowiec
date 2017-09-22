<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:12 PM
 */

namespace HeaderBundle\Controller;

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

                return $this->indexAction();
            }

            return $workshopAddHelper->getErrors($form);
        }

        return $this->render('HeaderBundle::workshop.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}