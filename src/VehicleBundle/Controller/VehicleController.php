<?php

namespace VehicleBundle\Controller;

use AppBundle\Entity\CarBrand;
use AppBundle\Entity\CarModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VehicleController extends Controller
{
    public function indexAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('VehicleBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Pojazdy',
        ]);
    }

    public function addAction()
    {

        $vehicleHelper = $this->get('vehicle.helper.add');

        $form = $vehicleHelper->createAddForm();

        if($vehicleHelper->isValid($form))
        {
            $vehicleHelper->write($form);

            return $this->redirectToRoute('vehicle_index');
        }

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('VehicleBundle::add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Dodawanie nowego pojazdu',
            'form'          => $form->createView(),
        ]);
    }


    public function editAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('VehicleBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Pojazdy',
        ]);
    }

    public function removeAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('VehicleBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Pojazdy',
        ]);
    }

    public function retrieveBrandsAction()
    {
        $carBrandHelper = $this->get('header.helper.car_brand');

        $brands = $carBrandHelper->getBrands();

        return $this->render('VehicleBundle::selectable_brand_content.html.twig', [
            'brands' => $brands,
        ]);
    }

    public function retrieveModelsAction()
    {
        $brandHelper = $this->get('header.helper.car_brand');
        $modelHelper = $this->get('header.helper.car_model');

        if(!$brandHelper->isRequestCorrect())
        {
            return $brandHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        /** @var CarBrand $brand */
        $brand = $brandHelper->getOneByName();

        if(null === $brand)
        {
            return $brandHelper->getErrorMessage('Nie ma takiej marki');
        }

        $models = $modelHelper->getModels($brand->getId());

        return $this->render('VehicleBundle::selectable_model_content.html.twig', [
            'models' => $models,
        ]);
    }
}