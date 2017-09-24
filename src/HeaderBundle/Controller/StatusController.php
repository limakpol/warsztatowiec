<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:13 PM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StatusController extends Controller
{
    public function indexAction()
    {
        $statusHelper = $this->get('header.helper.status');

        $statuses = $statusHelper->getStatuses();

        return $this->render('HeaderBundle::status.html.twig', [
            'statuses' => $statuses,
        ]);
    }

    public function addAction()
    {
        $statusHelper = $this->get('header.helper.status');

        if(!$statusHelper->isRequestCorrect())
        {
            return $statusHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$statusHelper->isValid())
        {
            return $statusHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($statusHelper->statusExists())
        {
            return $statusHelper->getErrorMessage('Taki status już istnieje');
        }

        if(null !== ($status = $statusHelper->statusExistsRemoved()))
        {
            $statusHelper->recover($status);

            return $this->indexAction();
        }

        $statusHelper->write();

        return $this->indexAction();
    }

    public function editAction()
    {
        $statusHelper = $this->get('header.helper.status');

        if(!$statusHelper->isRequestCorrect())
        {
            return $statusHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($status = $statusHelper->getOne()))
        {
            return $statusHelper->getErrorMessage('Wybrany status nie istnieje');
        }

        $statusHelper->edit($status);

        return $statusHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $statusHelper = $this->get('header.helper.status');

        if(!$statusHelper->isRequestCorrect())
        {
            return $statusHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($status = $statusHelper->getOne()))
        {
            return $statusHelper->getErrorMessage('Wybrany status nie istnieje');
        }

        $statusHelper->remove($status);

        return $this->indexAction();
    }
}