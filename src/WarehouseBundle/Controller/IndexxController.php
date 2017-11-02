<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 11/2/17
 * Time: 5:38 AM
 */

namespace WarehouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use WarehouseBundle\Service\Helper\IndexxHelper;

class IndexxController extends Controller
{

    public function editAction($indexxId)
    {
        /** @var IndexxHelper $indexxHelper */
        $indexxHelper = $this->get('warehouse.helper.indexx');

        $formData = $indexxHelper->createEditForm($indexxId);

        if(null === $formData)
        {
            return $this->redirectToRoute('warehouse_good_index');
        }

        if($indexxHelper->isEditFormValid($formData[0]))
        {
            $goodId = $indexxHelper->write($formData[0], $formData[1]);

            return $this->redirectToRoute('warehouse_good_show', [
                'goodId' => $goodId,
            ]);
        }

        $yamlParser     = $this->get('app.yaml_parser');

        $headerMenu     = $yamlParser->getHeaderMenu();
        $mainMenu       = $yamlParser->getMainMenu();

        return $this->render('WarehouseBundle:good:indexx_edit.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'warehouse',
            'navbar'        => 'Edycja indeksu',
            'form'          => $formData[0]->createView(),
        ]);
    }
}