<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:11 PM
 */

namespace HeaderBundle\Controller;

use AppBundle\Entity\CarBrand;
use AppBundle\Entity\CarModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CarModelController extends Controller
{
    public function indexAction($selectedBrandId = null)
    {

        $modelHelper = $this->get('header.helper.car_model');

        $models = $modelHelper->getModels($selectedBrandId);

        return $this->render('HeaderBundle::car_model.html.twig', [
            'error'     => null,
            'models'    => $models,
            'selectedBrandId' => $selectedBrandId,
        ]);
    }

    public function addAction()
    {
        $modelHelper = $this->get('header.helper.car_model');

        if(!$modelHelper->isRequestCorrect())
        {
            return $modelHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$modelHelper->isValid())
        {
            return $modelHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        /** @var CarBrand $brand */
        $brand = $modelHelper->getBrand();

        if(null === $brand)
        {
            return $modelHelper->getErrorMessage('Nie wybrano marki');
        }

        if($modelHelper->modelExists())
        {
            return $modelHelper->getErrorMessage('Taki model już istnieje');
        }

        if(null !== ($model = $modelHelper->modelExistsRemoved()))
        {
            $modelHelper->restore($model);

            return $this->indexAction($brand);
        }

        $modelHelper->write($brand);

        return $this->indexAction($brand->getId());
    }

    public function editAction()
    {
        $modelHelper = $this->get('header.helper.car_model');

        if(!$modelHelper->isRequestCorrect())
        {
            return $modelHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(null === ($model = $modelHelper->getOne()))
        {
            return $modelHelper->getErrorMessage('Wybrany model nie istnieje');
        }

        if(!$modelHelper->isValid())
        {
            return $modelHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if(true === $modelHelper->othersSimilarExists())
        {
            return $modelHelper->getErrorMessage('Taki model juz istnieje');
        }

        $modelHelper->edit($model);

        return $modelHelper->getSuccessMessage();
    }

    public function removeAction()
    {
        $modelHelper = $this->get('header.helper.car_model');

        if(!$modelHelper->isRequestCorrect())
        {
            return $modelHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        /** @var CarModel $model */
        $model = $modelHelper->getOne();

        if(null === $model)
        {
            return $modelHelper->getErrorMessage('Wybrany model nie istnieje');
        }

        $modelHelper->remove($model);

        return $this->indexAction($model->getBrandId());
    }


}