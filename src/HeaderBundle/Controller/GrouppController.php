<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/24/17
 * Time: 5:53 AM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class GrouppController extends Controller
{
    public function indexAction()
    {
        $grouppHelper = $this->get('header.helper.groupp');

        $groupps = $grouppHelper->getGroupps();

        return $this->render('HeaderBundle::groupp.html.twig', [
            'groupps' => $groupps,
        ]);
    }

    public function addAction()
    {
        $grouppHelper = $this->get('header.helper.groupp');

        if(!$grouppHelper->isRequestCorrect())
        {
            return $grouppHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$grouppHelper->isValid())
        {
            return $grouppHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($grouppHelper->grouppExists())
        {
            return $grouppHelper->getErrorMessage('Taka grupa już istnieje');
        }

        if(null !== ($groupp = $grouppHelper->grouppExistsRemoved()))
        {
            $grouppHelper->recover($groupp);

            return $this->indexAction();
        }

        $grouppHelper->write();

        return $this->indexAction();
    }

    public function editAction()
    {
        $grouppHelper = $this->get('header.helper.groupp');

        if(!$grouppHelper->isRequestCorrect())
        {
            return $grouppHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($groupp = $grouppHelper->getOne()))
        {
            return $grouppHelper->getErrorMessage('Wybrana grupa nie istnieje');
        }

        $grouppHelper->edit($groupp);

        return $grouppHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $grouppHelper = $this->get('header.helper.groupp');

        if(!$grouppHelper->isRequestCorrect())
        {
            return $grouppHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($groupp = $grouppHelper->getOne()))
        {
            return $grouppHelper->getErrorMessage('Wybrana grupa nie istnieje');
        }

        $grouppHelper->remove($groupp);

        return $this->indexAction();
    }
}