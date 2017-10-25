<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/24/17
 * Time: 7:29 PM
 */

namespace DeliveryBundle\Controller;


use DeliveryBundle\Service\Helper\DeliveryDetailAddHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WarehouseBundle\Service\Helper\GoodHelper;
use WarehouseBundle\Service\Helper\IndexxHelper;

class DeliveryDetailController extends Controller
{

    public function addAction()
    {
        /** @var DeliveryDetailAddHelper $detailAddHelper */
        $detailAddHelper = $this->get('delivery.helper.detail_add');

        /** @var GoodHelper $goodHelper */
        $goodHelper = $this->get('warehouse.helper.good');

        /** @var IndexxHelper $indexxHelper */
        $indexxHelper = $this->get('warehouse.helper.indexx');

        $goodSortableParameters = $detailAddHelper->getGoodSortableParameters();
        $indexxSortableParameters = $detailAddHelper->getIndexxSortableParameters();

        $goods = $goodHelper->retrieve($goodSortableParameters);
        $indexxes = $indexxHelper->retrieve($indexxSortableParameters);

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('DeliveryBundle:detail:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Dodawanie pozycji przyjęcia',
            'goods'         => $goods,
            'indexxes'      => $indexxes,
            'goodSortableParameters' => $goodSortableParameters,
            'indexxSortableParameters' => $indexxSortableParameters,
        ]);
    }

    public function retrieveGoodsAction()
    {
        /** @var DeliveryDetailAddHelper $detailAddHelper */
        $detailAddHelper = $this->get('delivery.helper.detail_add');

        /** @var GoodHelper $goodHelper */
        $goodHelper = $this->get('warehouse.helper.good');

        $sortableParameters = $detailAddHelper->getGoodSortableParameters();

        $goods = $goodHelper->retrieve($sortableParameters);

        return $this->render('DeliveryBundle:detail:good_searchable_content.html.twig', [
            'goods' => $goods,
            'goodSortableParameters' => $sortableParameters,
        ]);

    }

    public function retrieveIndexxesAction()
    {

        /** @var DeliveryDetailAddHelper $detailAddHelper */
        $detailAddHelper = $this->get('delivery.helper.detail_add');

        /** @var IndexxHelper $indexxHelper */
        $indexxHelper = $this->get('warehouse.helper.indexx');

        $sortableParameters = $detailAddHelper->getIndexxSortableParameters();

        $indexxes = $indexxHelper->retrieve($sortableParameters);

        return $this->render('DeliveryBundle:detail:good_searchable_content.html.twig', [
            'indexxes' => $indexxes,
            'indexxSortableParameters' => $sortableParameters,
        ]);
    }


}