<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/3/17
 * Time: 9:38 PM
 */

namespace OrderBundle\Controller;


use OrderBundle\Service\Helper\OrderActionHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderActionController extends Controller
{
    public function addAction($orderHeaderId, $orderIndexxId)
    {
        /** @var OrderActionHelper $orderActionHelper */
        $orderActionHelper = $this->get('order_helper_action');

        $orderHeader = $orderActionHelper->getOrderHeader($orderHeaderId);
        $orderIndexx = $orderActionHelper->getOrderIndexx($orderIndexxId);

        if(null === $orderHeader)
        {
            return $this->redirectToRoute('order_index');
        }

        if(null === $orderIndexx)
        {
            return $this->redirectToRoute('order_show', [
                'orderHeaderId' => $orderHeaderId,
            ]);
        }

        $form = $orderActionHelper->createForm();

        if($orderActionHelper->isValid($form))
        {
            $orderActionHelper->write($form, $orderIndexx);

            return $this->redirectToRoute('order_show', [
                'orderHeaderId' => $orderHeaderId,
            ]);
        }

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('OrderBundle:action:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'order',
            'navbar'        => 'Dodawanie czynności do towaru w zleceniu',
            'form'          => $form->createView(),
        ]);
    }
}