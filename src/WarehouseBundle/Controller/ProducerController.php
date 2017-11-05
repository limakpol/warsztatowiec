<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 2:27 AM
 */

namespace WarehouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProducerController extends Controller
{

    public function indexAction()
    {
        $producerHelper = $this->get('warehouse.helper.producer');
        $yamlParser     = $this->get('app.yaml_parser');

        $headerMenu     = $yamlParser->getHeaderMenu();
        $mainMenu       = $yamlParser->getMainMenu();

        $producers = $producerHelper->getProducers();

        return $this->render('WarehouseBundle:producer:index.html.twig', [
            'producers'     => $producers,
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Producenci towarów i części samochodowych',
        ]);
    }

    public function addAction()
    {
        $producerHelper = $this->get('warehouse.helper.producer');

        if(!$producerHelper->isRequestCorrect())
        {
            return $producerHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$producerHelper->isValid())
        {
            return $producerHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($producerHelper->producerExists())
        {
            return $producerHelper->getErrorMessage('Producent o takiej nazwie już istnieje');
        }

        if(null !== ($producer = $producerHelper->producerExistsRemoved()))
        {
            $producerHelper->recover($producer);

            return $this->indexAction();
        }

        $producerHelper->write();

        $producers = $producerHelper->getProducers();

        return $this->render('WarehouseBundle:producer:content.html.twig', [
            'producers' => $producers,
        ]);
    }

    public function editAction()
    {
        $producerHelper = $this->get('warehouse.helper.producer');

        if(!$producerHelper->isRequestCorrect())
        {
            return $producerHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($producer = $producerHelper->getOne()))
        {
            return $producerHelper->getErrorMessage('Wybrany producent nie istnieje');
        }

        $producerHelper->edit($producer);

        return $producerHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $producerHelper = $this->get('warehouse.helper.producer');

        if(!$producerHelper->isRequestCorrect())
        {
            return $producerHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($producer = $producerHelper->getOne()))
        {
            return $producerHelper->getErrorMessage('Wybrany producent nie istnieje');
        }

        $producerHelper->remove($producer);

        $producers = $producerHelper->getProducers();

        return $this->render('WarehouseBundle:producer:content.html.twig', [
            'producers' => $producers,
        ]);
    }
}