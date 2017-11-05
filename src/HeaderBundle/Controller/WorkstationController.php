<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:13 PM
 */

namespace HeaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkstationController extends Controller
{
    public function indexAction()
    {
        $workstationHelper = $this->get('header.helper.workstation');

        $workstations = $workstationHelper->getWorkstations();

        return $this->render('HeaderBundle::workstation.html.twig', [
            'workstations' => $workstations,
        ]);
    }

    public function addAction()
    {
        $workstationHelper = $this->get('header.helper.workstation');

        if(!$workstationHelper->isRequestCorrect())
        {
            return $workstationHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$workstationHelper->isValid())
        {
            return $workstationHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($workstationHelper->workstationExists())
        {
            return $workstationHelper->getErrorMessage('Takie stanowisko już istnieje');
        }

        if(null !== ($workstation = $workstationHelper->workstationExistsRemoved()))
        {
            $workstationHelper->restore($workstation);

            return $this->indexAction();
        }

        $workstationHelper->write();

        return $this->indexAction();
    }

    public function editAction()
    {
        $workstationHelper = $this->get('header.helper.workstation');

        if(!$workstationHelper->isRequestCorrect())
        {
            return $workstationHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($workstation = $workstationHelper->getOne()))
        {
            return $workstationHelper->getErrorMessage('Wybrane stanowisko nie istnieje');
        }

        $workstationHelper->edit($workstation);

        return $workstationHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $workstationHelper = $this->get('header.helper.workstation');

        if(!$workstationHelper->isRequestCorrect())
        {
            return $workstationHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($workstation = $workstationHelper->getOne()))
        {
            return $workstationHelper->getErrorMessage('Wybrane stanowisko nie istnieje');
        }

        $workstationHelper->remove($workstation);

        return $this->indexAction();
    }
}