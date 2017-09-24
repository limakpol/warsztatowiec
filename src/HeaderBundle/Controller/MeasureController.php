<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:11 PM
 */

namespace HeaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MeasureController extends Controller
{
    public function indexAction()
    {

        $measureHelper = $this->get('header.helper.measure.general');

        $goodMeasures = $measureHelper->getMeasures('good');

        $serviceMeasures = $measureHelper->getMeasures('service');

        return $this->render('HeaderBundle::measure.html.twig', [
            'error'             => null,
            'goodMeasures'      => $goodMeasures,
            'serviceMeasures'   => $serviceMeasures,
        ]);
    }

    public function addAction()
    {
        $measureHelper = $this->get('header.helper.measure.general');

        if(!$measureHelper->isRequestCorrect())
        {
            return $measureHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$measureHelper->isValid())
        {
            return $measureHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($measureHelper->measureExists())
        {
            return $measureHelper->getErrorMessage('Taka jednostka już istnieje');
        }

        if(null !== ($measure = $measureHelper->measureExistsRemoved()))
        {
            $measureHelper->recover($measure);

            return $this->indexAction();
        }

        $measureHelper->write();

        return $this->indexAction();
    }

    public function editAction()
    {
        $measureHelper = $this->get('header.helper.measure.general');

        if(!$measureHelper->isRequestCorrect())
        {
            return $measureHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($measure = $measureHelper->getOne()))
        {
            return $measureHelper->getErrorMessage('Wybrana jednostka nie istnieje');
        }

        $measureHelper->edit($measure);

        return $measureHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $measureHelper = $this->get('header.helper.measure.general');

        if(!$measureHelper->isRequestCorrect())
        {
            return $measureHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($measure = $measureHelper->getOne()))
        {
            return $measureHelper->getErrorMessage('Wybrana jednostka nie istnieje');
        }

        if($measureHelper->isLast($measure))
        {
            return $measureHelper->getErrorMessage('Musi istnieć przynajmniej jedna jednostka danego typu');
        }

        $measureHelper->remove($measure);

        return $this->indexAction();
    }


}