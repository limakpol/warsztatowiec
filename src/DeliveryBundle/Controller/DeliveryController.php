<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/17/17
 * Time: 4:39 PM
 */

namespace DeliveryBundle\Controller;


use AppBundle\Entity\DeliveryHeader;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends Controller
{

    public function indexAction()
    {
        $indexHelper = $this->get('delivery.helper.index');

        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $deliveryHeaders  = $indexHelper->retrieve($sortableParameters);

        $limitSet   = $this->getParameter('app')['limit_set'];

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('DeliveryBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Przyjęcia towarów',
            'deliveryHeaders'     => $deliveryHeaders,
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

        $indexHelper = $this->get('delivery.helper.index');
        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $deliveryHeaders  = $indexHelper->retrieve($sortableParameters);

        $limitSet   = $this->getParameter('app')['limit_set'];

        return $this->render('DeliveryBundle::sortable_content.html.twig', [
            'deliveryHeaders' => $deliveryHeaders,
            'limitSet' => $limitSet,
            'sortableParameters' => $sortableParameters,
        ]);
    }
    
    public function showAction($deliveryHeaderId)
    {
        $deliveryShowHelper = $this->get('delivery.helper.show');

        /** @var DeliveryHeader $deliveryHeader */
        $deliveryHeader = $deliveryShowHelper->getDelivery($deliveryHeaderId);

        if(null === $deliveryHeader)
        {
            return $this->redirectToRoute('delivery_index');
        }

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('DeliveryBundle::show.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Przyjęcie towaru',
            'deliveryHeader'    => $deliveryHeader,
        ]);
    }

    public function removeAction()
    {
        return new Response();
    }
}