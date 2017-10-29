<?php

namespace WarehouseBundle\Controller;

use AppBundle\Entity\Good;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class WarehouseController extends Controller
{
    public function indexAction()
    {
        $indexHelper = $this->get('warehouse.helper.good');

        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $goods  = $indexHelper->retrieve($sortableParameters);

        $limitSet   = $this->getParameter('app')['limit_set'];

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WarehouseBundle:good:index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Towary',
            'goods'         => $goods,
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

        $indexHelper = $this->get('warehouse.helper.good');
        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $goods  = $indexHelper->retrieve($sortableParameters);

        $limitSet   = $this->getParameter('app')['limit_set'];

        return $this->render('WarehouseBundle:good:sortable_content.html.twig', [
            'goods' => $goods,
            'limitSet' => $limitSet,
            'sortableParameters' => $sortableParameters,
        ]);
    }

    public function showAction($goodId)
    {
        $showHelper = $this->get('warehouse.helper.good_show');

        /** @var Good $good */
        $good = $showHelper->getGood($goodId);

        if(null === $good)
        {
            return $this->redirectToRoute('warehouse_good_index');
        }

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('WarehouseBundle:good:show.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Towar',
            'good'          => $good,
        ]);
    }

}