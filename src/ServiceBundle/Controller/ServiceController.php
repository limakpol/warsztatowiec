<?php

namespace ServiceBundle\Controller;

use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServiceController extends Controller
{
    public function indexAction()
    {
        $serviceHelper  = $this->get('service.helper.service');
        $yamlParser     = $this->get('app.yaml_parser');

        $headerMenu     = $yamlParser->getHeaderMenu();
        $mainMenu       = $yamlParser->getMainMenu();

        $services       = $serviceHelper->getServices();
        $measures       = $serviceHelper->getMeasures();

        return $this->render('ServiceBundle:service:index.html.twig', [
            'services'      => $services,
            'measures'      => $measures,
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'service',
            'navbar'        => 'Usługi',
        ]);
    }

    public function addAction()
    {
        $serviceHelper = $this->get('service.helper.service');

        if(!$serviceHelper->isRequestCorrect())
        {
            return $serviceHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$serviceHelper->isValid())
        {
            return $serviceHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($serviceHelper->serviceExists())
        {
            return $serviceHelper->getErrorMessage('Usługa o takiej nazwie już istnieje');
        }

        if(null !== ($service = $serviceHelper->serviceExistsRemoved()))
        {
            $serviceHelper->recover($service);

            return $this->indexAction();
        }

        $serviceHelper->write();

        $services   = $serviceHelper->getServices();
        $measures   = $serviceHelper->getMeasures();

        return $this->render('ServiceBundle:service:content.html.twig', [
            'services' => $services,
            'measures' => $measures,
        ]);
    }

    public function editAction()
    {
        $serviceHelper = $this->get('service.helper.service');

        if(!$serviceHelper->isRequestCorrect())
        {
            return $serviceHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($service = $serviceHelper->getOne()))
        {
            return $serviceHelper->getErrorMessage('Wybrana usługa nie istnieje');
        }

        $serviceHelper->edit($service);

        return $serviceHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $serviceHelper = $this->get('service.helper.service');

        if(!$serviceHelper->isRequestCorrect())
        {
            return $serviceHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($service = $serviceHelper->getOne()))
        {
            return $serviceHelper->getErrorMessage('Wybrana usługa nie istnieje');
        }

        $serviceHelper->remove($service);

        $services   = $serviceHelper->getServices();
        $measures   = $serviceHelper->getMeasures();

        return $this->render('ServiceBundle:service:content.html.twig', [
            'services' => $services,
            'measures' => $measures,
        ]);
    }

    public function getOneAction($hydrationMode = Query::HYDRATE_OBJECT)
    {
        $serviceHelper = $this->get('service.helper.service');

        $service = $serviceHelper->getOne($hydrationMode);

        if(null == $service)
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => ['Nie ma takiej usługi'],
            ]);
        }

        return new JsonResponse($service);
    }

}