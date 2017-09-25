<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 2:30 AM
 */

namespace ServiceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ActionController extends Controller
{

    public function indexAction()
    {
        $actionHelper = $this->get('service.helper.action');
        $yamlParser     = $this->get('app.yaml_parser');

        $headerMenu     = $yamlParser->getHeaderMenu();
        $mainMenu       = $yamlParser->getMainMenu();

        $actions = $actionHelper->getActions();

        return $this->render('ServiceBundle:action:index.html.twig', [
            'actions'     => $actions,
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'service',
            'navbar'        => 'Czynności dodawane do towarów w zleceniach',
        ]);
    }

    public function addAction()
    {
        $actionHelper = $this->get('service.helper.action');

        if(!$actionHelper->isRequestCorrect())
        {
            return $actionHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$actionHelper->isValid())
        {
            return $actionHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($actionHelper->actionExists())
        {
            return $actionHelper->getErrorMessage('Producent o takiej nazwie już istnieje');
        }

        if(null !== ($action = $actionHelper->actionExistsRemoved()))
        {
            $actionHelper->recover($action);

            return $this->indexAction();
        }

        $actionHelper->write();

        $actions = $actionHelper->getActions();

        return $this->render('ServiceBundle:action:content.html.twig', [
            'actions' => $actions,
        ]);
    }

    public function editAction()
    {
        $actionHelper = $this->get('service.helper.action');

        if(!$actionHelper->isRequestCorrect())
        {
            return $actionHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($action = $actionHelper->getOne()))
        {
            return $actionHelper->getErrorMessage('Wybrany producent nie istnieje');
        }

        $actionHelper->edit($action);

        return $actionHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $actionHelper = $this->get('service.helper.action');

        if(!$actionHelper->isRequestCorrect())
        {
            return $actionHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($action = $actionHelper->getOne()))
        {
            return $actionHelper->getErrorMessage('Wybrany producent nie istnieje');
        }

        $actionHelper->remove($action);

        $actions = $actionHelper->getActions();

        return $this->render('ServiceBundle:action:content.html.twig', [
            'actions' => $actions,
        ]);
    }
}