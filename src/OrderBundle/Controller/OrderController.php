<?php

namespace OrderBundle\Controller;

use OrderBundle\Service\Helper\OrderHelper;
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
        $statuses = $indexHelper->getStatuses();

        $limitSet   = $this->getParameter('app')['limit_set'];

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('OrderBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Zlecenia serwisowe',
            'orderHeaders'  => $orderHeaders,
            'statuses'      => $statuses,
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
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');

        $orderHeader = $orderHelper->getOrderHeader($orderHeaderId);

        if(null === $orderHeader)
        {
            return $this->redirectToRoute('order_index');
        }

        $workstations = $orderHelper->getWorkstations($orderHeaderId);

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        $symptoms = $orderHelper->retrieveSymptoms();

        return $this->render('OrderBundle::show.html.twig', [
            'orderHeaderId' => $orderHeaderId,
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Zlecenie serwisowe',
            'orderHeader'   => $orderHeader,
            'workstations'  => $workstations,
            'symptoms'      => $symptoms,
        ]);
    }
}