<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:11 PM
 */

namespace HeaderBundle\Controller;

use AppBundle\Entity\CarBrand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CarBrandController extends Controller
{
    public function indexAction($selectedBrandId = null)
    {

        $brandHelper = $this->get('header.helper.car_brand');
        $modelHelper = $this->get('header.helper.car_model');

        if(!$brandHelper->isRequestCorrect())
        {
            return $brandHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        $brands = $brandHelper->getBrands();
        $models = [];

        if(null === $selectedBrandId)
        {
            if(isset($brands[0]) && $brands[0] instanceof CarBrand)
            {
                /** @var CarBrand $brand */
                $brand = $brands[0];

                $selectedBrandId = $brand->getId();

                $models = $modelHelper->getModels($brand->getId());
            }
        }
        else
        {
            /** @var CarBrand $brand */
            $brand = $brandHelper->getOneById($selectedBrandId);

            $models = $modelHelper->getModels($brand->getId());
        }

        return $this->render('HeaderBundle::car.html.twig', [
            'error'             => null,
            'brands'            => $brands,
            'selectedBrandId'   => $selectedBrandId,
            'models'            => $models,
        ]);
    }

    public function addAction()
    {
        $brandHelper = $this->get('header.helper.car_brand');

        if(!$brandHelper->isRequestCorrect())
        {
            return $brandHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$brandHelper->isValid())
        {
            return $brandHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($brandHelper->brandExists())
        {
            return $brandHelper->getErrorMessage('Taka marka już istnieje');
        }

        if(null !== ($brand = $brandHelper->brandExistsRemoved()))
        {
            $brandHelper->restore($brand);

            return $this->indexAction($brand->getId());
        }

        $brand = $brandHelper->write();

        return $this->indexAction($brand->getId());
    }

    public function editAction()
    {
        $brandHelper = $this->get('header.helper.car_brand');

        if(!$brandHelper->isRequestCorrect())
        {
            return $brandHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($brand = $brandHelper->getOne()))
        {
            return $brandHelper->getErrorMessage('Wybrana marka nie istnieje');
        }

        if(!$brandHelper->isValid())
        {
            return $brandHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if(true === $brandHelper->othersSimilarExists())
        {
            return $brandHelper->getErrorMessage('Taka marka juz istnieje');
        }

        $brandHelper->edit($brand);

        return $brandHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $brandHelper = $this->get('header.helper.car_brand');

        if(!$brandHelper->isRequestCorrect())
        {
            return $brandHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($brand = $brandHelper->getOne()))
        {
            return $brandHelper->getErrorMessage('Wybrana marka nie istnieje');
        }

        $brandHelper->remove($brand);

        return $this->indexAction();
    }
}