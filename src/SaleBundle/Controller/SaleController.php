<?php

namespace SaleBundle\Controller;

use AppBundle\Entity\SaleHeader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SaleController extends Controller
{
    public function indexAction()
    {
        $indexHelper = $this->get('sale.helper.index');

        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $saleHeaders  = $indexHelper->retrieve($sortableParameters);

        $limitSet   = $this->getParameter('app')['limit_set'];

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('SaleBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Wystawienia towarów',
            'saleHeaders'     => $saleHeaders,
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

        $indexHelper = $this->get('sale.helper.index');
        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $saleHeaders  = $indexHelper->retrieve($sortableParameters);

        $limitSet   = $this->getParameter('app')['limit_set'];

        return $this->render('SaleBundle::sortable_content.html.twig', [
            'saleHeaders' => $saleHeaders,
            'limitSet' => $limitSet,
            'sortableParameters' => $sortableParameters,
        ]);
    }

    public function showAction($saleHeaderId)
    {
        $saleShowHelper = $this->get('sale.helper.show');

        /** @var SaleHeader $saleHeader */
        $saleHeader = $saleShowHelper->getSale($saleHeaderId);

        if(null === $saleHeader)
        {
            return $this->redirectToRoute('sale_index');
        }

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('SaleBundle::show.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Wystawienie towaru',
            'saleHeader'    => $saleHeader,
        ]);
    }

    public function removeAction()
    {
        return new Response();
    }


}
