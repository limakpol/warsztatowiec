<?php

namespace OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    public function indexAction()
    {
        $indexHelper = $this->get('order.helper.index');

        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $orderHeaders  = $indexHelper->retrieve($sortableParameters);

        $limitSet   = $this->getParameter('app')['limit_set'];

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('OrderBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Zlecenia serwisowe',
            'orderHeaders'     => $orderHeaders,
            'limitSet'      => $limitSet,
            'sortableParameters' => $sortableParameters,
        ]);
    }

    public function retrieveAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        if(!$request->isMethod('POST') || !$request->isXmlHttpRequest())
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => ['Nieprawidłowe żądanie'],
            ]);
        }

        $indexHelper = $this->get('order.helper.index');
        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $orderHeaders  = $indexHelper->retrieve($sortableParameters);

        $limitSet   = $this->getParameter('app')['limit_set'];

        return $this->render('OrderBundle::sortable_content.html.twig', [
            'orderHeaders' => $orderHeaders,
            'limitSet' => $limitSet,
            'sortableParameters' => $sortableParameters,
        ]);
    }
    public function showAction($orderHeaderId)
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('OrderBundle::show.html.twig', [
            'orderHeaderId' => $orderHeaderId,
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Przyjęcie towaru',
        ]);
    }


    

}