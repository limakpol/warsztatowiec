<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/24/17
 * Time: 7:29 PM
 */

namespace SaleBundle\Controller;


use AppBundle\Entity\Good;
use AppBundle\Entity\Indexx;
use AppBundle\Entity\SaleDetail;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use SaleBundle\Form\SaleDetailAddType;
use SaleBundle\Service\Helper\SaleDetailAddHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use WarehouseBundle\Service\Helper\GoodHelper;
use WarehouseBundle\Service\Helper\IndexxHelper;

class SaleDetailController extends Controller
{

    public function addAction($saleHeaderId)
    {
        /** @var SaleDetailAddHelper $detailAddHelper */
        $detailAddHelper = $this->get('sale.helper.detail_add');

        /** @var GoodHelper $goodHelper */
        $goodHelper = $this->get('warehouse.helper.good');

        /** @var IndexxHelper $indexxHelper */
        $indexxHelper = $this->get('warehouse.helper.indexx');

        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        if(null === ($saleHeader = $detailAddHelper->getHeader($saleHeaderId)))
        {
            return $this->redirectToRoute('sale_index');
        }

        $saleDetail = new SaleDetail();

        $form = $this->createForm(SaleDetailAddType::class, $saleDetail, [
            'validation_groups' => ['sale_detail_add', 'good', 'indexx']
        ]);

        $indexxError    = null;
        $goodError      = null;

        if($request->isMethod('POST'))
        {
            $indexxId   = $request->get('sale_detail_add')['indexx_id'];
            $goodId     = $request->get('sale_detail_add')['indexx']['good_id'];

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

                $saleDetail->setIndexx($indexx);

                $form->setData($saleDetail);

                $form->submit($request->request->get($form->getName()));

                if($form->isValid())
                {
                    $detailAddHelper->write($form, $saleHeader, $prevGood, $prevIndexxQty);

                    return $this->redirectToRoute('sale_show', [
                        'saleHeaderId' => $saleHeaderId,
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

        return $this->render('SaleBundle:detail:add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Dodawanie pozycji wystawienia',
            'form'          => $form->createView(),
            'goods'         => $goods,
            'indexxes'      => $indexxes,
            'goodSortableParameters' => $goodSortableParameters,
            'indexxSortableParameters' => $indexxSortableParameters,
            'goodError' => $goodError,
            'indexxError' => $indexxError,
        ]);
    }

    public function retrieveGoodsAction()
    {
        /** @var SaleDetailAddHelper $detailAddHelper */
        $detailAddHelper = $this->get('sale.helper.detail_add');

        /** @var GoodHelper $goodHelper */
        $goodHelper = $this->get('warehouse.helper.good');

        $sortableParameters = $detailAddHelper->getGoodSortableParameters();

        $goods = $goodHelper->retrieve($sortableParameters);

        return $this->render('SaleBundle:detail:good_searchable_content.html.twig', [
            'goods' => $goods,
            'goodSortableParameters' => $sortableParameters,
        ]);

    }

    public function retrieveIndexxesAction()
    {

        /** @var SaleDetailAddHelper $detailAddHelper */
        $detailAddHelper = $this->get('sale.helper.detail_add');

        /** @var IndexxHelper $indexxHelper */
        $indexxHelper = $this->get('warehouse.helper.indexx');

        $sortableParameters = $detailAddHelper->getIndexxSortableParameters();

        $indexxes = $indexxHelper->retrieve($sortableParameters);

        return $this->render('SaleBundle:detail:indexx_searchable_content.html.twig', [
            'indexxes' => $indexxes,
            'indexxSortableParameters' => $sortableParameters,
        ]);
    }


}