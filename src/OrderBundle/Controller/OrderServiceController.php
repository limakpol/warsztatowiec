<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/3/17
 * Time: 9:38 PM
 */

namespace OrderBundle\Controller;

use OrderBundle\Service\Helper\OrderServiceHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WorkflowBundle\Service\Helper\WorkmanIndexHelper;

class OrderServiceController extends Controller
{
    public function addAction($orderHeaderId)
    {
        /** @var OrderServiceHelper $orderServiceHelper */
        $orderServiceHelper = $this->get('order_helper_service');

        $orderHeader = $orderServiceHelper->getHeader($orderHeaderId);

        if(null === $orderHeader)
        {
            return $this->redirectToRoute('order_index');
        }

        $form = $orderServiceHelper->createForm();

        if($orderServiceHelper->isValid($form))
        {
            $orderServiceHelper->write($form, $orderHeader);

            return $this->redirectToRoute('order_show', [
                'orderHeaderId' => $orderHeaderId,
            ]);
        }

        /** @var WorkmanIndexHelper $workmaIndexxHelper */
        $workmaIndexxHelper = $this->get('workflow.helper.workman_index');

        $workmans = $workmaIndexxHelper->retrieve();

        $sortableParameters = $orderServiceHelper->getSortableParamaters();
        $services = $orderServiceHelper->retrieveServices($sortableParameters);

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('OrderBundle:service:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Dodawanie usługi do zlecenia',
            'services'      => $services,
            'sortableParameters' => $sortableParameters,
            'form'          => $form->createView(),
            'workmans'      => $workmans,
        ]);
    }

    public function retrieveAction()
    {
        /** @var OrderServiceHelper $orderServiceHelper */
        $orderServiceHelper = $this->get('order_helper_service');

        $sortableParamters = $orderServiceHelper->getSortableParamaters();
        $services = $orderServiceHelper->retrieveServices($sortableParamters);

        return $this->render('OrderBundle:service:service_searchable_content.html.twig', [
            'services' => $services,
            'sortableParameters' => $sortableParamters,
        ]);
    }
}