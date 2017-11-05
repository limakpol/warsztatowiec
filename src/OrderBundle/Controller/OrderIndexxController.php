<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/3/17
 * Time: 9:38 PM
 */

namespace OrderBundle\Controller;

use AppBundle\Entity\Good;
use AppBundle\Entity\Indexx;
use AppBundle\Entity\OrderIndexx;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use OrderBundle\Form\OrderIndexxAddType;
use OrderBundle\Service\Helper\OrderHelper;
use OrderBundle\Service\Helper\OrderIndexxAddHelper;
use SaleBundle\Service\Helper\SaleDetailAddHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WarehouseBundle\Service\Helper\GoodHelper;
use WarehouseBundle\Service\Helper\IndexxHelper;

class OrderIndexxController extends Controller
{
    public function addAction($orderHeaderId)
    {

        /** @var SaleDetailAddHelper $detailAddHelper */
        $detailAddHelper = $this->get('sale.helper.detail_add');

        /** @var GoodHelper $goodHelper */
        $goodHelper = $this->get('warehouse.helper.good');
        
        /** @var OrderHelper $orderHelper */
        $orderHelper = $this->get('order.helper');

        /** @var IndexxHelper $indexxHelper */
        $indexxHelper = $this->get('warehouse.helper.indexx');

        /** @var OrderIndexxAddHelper $orderIndexxAddHelper */
        $orderIndexxAddHelper = $this->get('order.helper.indexx_add');

        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        if(null === ($orderHeader = $orderHelper->getOrderHeader($orderHeaderId)))
        {
            return $this->redirectToRoute('order_index');
        }

        $orderIndexx = new OrderIndexx();

        $form = $this->createForm(OrderIndexxAddType::class, $orderIndexx, [
            'validation_groups' => ['order_indexx_add', 'good', 'indexx', 'indexx_edit']
        ]);

        $indexxError    = null;
        $goodError      = null;
        $exceedQtyError = null;

        if($request->isMethod('POST'))
        {
            $indexxId   = $request->get('order_indexx_add')['indexx_id'];
            $goodId     = $request->get('order_indexx_add')['indexx']['good_id'];
            
            /** @var Indexx $indexx */
            $indexx = $em->getRepository('AppBundle:Indexx')->getOne($workshop, $indexxId);

            /** @var Good $good */
            $good = $em->getRepository('AppBundle:Good')->getOne($workshop, $goodId);

            if(null === $indexx)
            {
                $indexxError = 'Nie wybrano indeksu';
            }

            if(null === $good)
            {
                $goodError = 'Nie wybrano towaru';
            }

            if(null !== $indexx && null !== $good)
            {
                $prevGood = $indexx->getGood();

                $prevIndexxQty = $indexx->getQuantity();

                $indexx->setGood($good);

                $orderIndexx->setIndexx($indexx);

                $form->setData($orderIndexx);

                $form->submit($request->request->get($form->getName()));

                $exceedQtyError = $orderIndexx->getQuantity() > $indexx->getQuantity() ? true : null;

                if($form->isValid() && !$exceedQtyError)
                {
                    $orderIndexxAddHelper->write($form, $orderHeader, $prevGood, $prevIndexxQty);

                    return $this->redirectToRoute('order_show', [
                        'orderHeaderId' => $orderHeaderId,
                    ]);
                }
            }
            else
            {
                $form->submit($request->request->get($form->getName()));
            }
        }

        $goodSortableParameters = $detailAddHelper->getGoodSortableParameters();
        $indexxSortableParameters = $detailAddHelper->getIndexxSortableParameters();

        $goods = $goodHelper->retrieve($goodSortableParameters);
        $indexxes = $indexxHelper->retrieve($indexxSortableParameters);

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('OrderBundle:indexx:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Dodawanie towaru do zlecenia',
            'form'          => $form->createView(),
            'goods'         => $goods,
            'indexxes'      => $indexxes,
            'goodSortableParameters' => $goodSortableParameters,
            'indexxSortableParameters' => $indexxSortableParameters,
            'goodError' => $goodError,
            'indexxError' => $indexxError,
            'exceedQtyError' => $exceedQtyError,
        ]);
    }
}