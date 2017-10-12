<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:13 PM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PositionController extends Controller
{
    public function indexAction()
    {
        $positionHelper = $this->get('header.helper.position');

        $positions = $positionHelper->getPositions();

        return $this->render('HeaderBundle::position.html.twig', [
            'positions' => $positions,
        ]);
    }

    public function addAction()
    {
        $positionHelper = $this->get('header.helper.position');

        if(!$positionHelper->isRequestCorrect())
        {
            return $positionHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$positionHelper->isValid())
        {
            return $positionHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($positionHelper->positionExists())
        {
            return $positionHelper->getErrorMessage('Takie stanowisko już istnieje');
        }

        if(null !== ($position = $positionHelper->positionExistsRemoved()))
        {
            $positionHelper->restore($position);

            return $this->indexAction();
        }

        $positionHelper->write();

        return $this->indexAction();
    }

    public function editAction()
    {
        $positionHelper = $this->get('header.helper.position');

        if(!$positionHelper->isRequestCorrect())
        {
            return $positionHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($position = $positionHelper->getOne()))
        {
            return $positionHelper->getErrorMessage('Wybrane stanowisko nie istnieje');
        }

        $positionHelper->edit($position);

        return $positionHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $positionHelper = $this->get('header.helper.position');

        if(!$positionHelper->isRequestCorrect())
        {
            return $positionHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($position = $positionHelper->getOne()))
        {
            return $positionHelper->getErrorMessage('Wybrane stanowisko nie istnieje');
        }

        $positionHelper->remove($position);

        return $this->indexAction();
    }
}