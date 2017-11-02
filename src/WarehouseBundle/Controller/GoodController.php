<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/2/17
 * Time: 10:13 AM
 */

namespace WarehouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WarehouseBundle\Service\Helper\GoodHelper;

class GoodController extends Controller
{
    public function editAction($goodId)
    {
        /** @var GoodHelper $goodHelper */
        $goodHelper = $this->get('warehouse.helper.good');

        $form = $goodHelper->createEditForm($goodId);

        if(null === $form)
        {
            return $this->redirectToRoute('warehouse_good_index');
        }

        if($goodHelper->isEditFormValid($form))
        {
            $goodId = $goodHelper->write($form);

            return $this->redirectToRoute('warehouse_good_show', [
                'goodId' => $goodId,
            ]);
        }

        $categories = $goodHelper->getCategoriesByGoodIds([$goodId]);
        $carModels  = $goodHelper->getCarModelsByGoodIds([$goodId]);

        $yamlParser     = $this->get('app.yaml_parser');

        $headerMenu     = $yamlParser->getHeaderMenu();
        $mainMenu       = $yamlParser->getMainMenu();

        return $this->render('WarehouseBundle:good:good_edit.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Edycja towaru',
            'form'          => $form->createView(),
            'goodId'        => $goodId,
            'categories'    => $categories,
            'carModels'     => $carModels,
        ]);
    }
}