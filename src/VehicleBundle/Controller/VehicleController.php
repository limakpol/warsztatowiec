<?php

namespace VehicleBundle\Controller;

use AppBundle\Entity\CarBrand;
use AppBundle\Entity\Customer;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class VehicleController extends Controller
{
    public function indexAction()
    {
        $indexHelper = $this->get('vehicle.helper.index');

        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $vehicles  = $indexHelper->retrieve($sortableParameters);
        $limitSet   = $this->getParameter('app')['limit_set'];

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('VehicleBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Pojazdy',
            'vehicles'     => $vehicles,
            'limitSet'      => $limitSet,
            'sortableParameters' => $sortableParameters,
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

    public function showAction($vehicleId)
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('VehicleBundle::show.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Pojazd',
            'vehicleId'     => $vehicleId,
        ]);
    }

    public function retrieveAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        if(!$request->isMethod('POST') || !$request->isXmlHttpRequest())
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => ['Nieprawidłowe żądanie'],
            ]);
        }

        $indexHelper = $this->get('vehicle.helper.index');
        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $vehicles  = $indexHelper->retrieve($sortableParameters);

        $limitSet   = $this->getParameter('app')['limit_set'];

        return $this->render('VehicleBundle::sortable_content.html.twig', [
            'vehicles' => $vehicles,
            'limitSet' => $limitSet,
            'sortableParameters' => $sortableParameters,
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

    public function getOneAction($hydrationMode = Query::HYDRATE_OBJECT)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var array $vehicleArray */
        $vehicleArray =  $em->getRepository('AppBundle:Vehicle')
            ->getOne($workshop, $request->get('vehicleId'), $hydrationMode);

        /** @var Vehicle $vehicle */
        $vehicle = $em->getRepository('AppBundle:Vehicle')->getOne($workshop, $request->get('vehicleId'), 1);

        $brandName = $vehicle->getCarModel()->getBrand()->getName();
        $modelName = $vehicle->getCarModel()->getName();
        $dateOfInspection = $vehicle->getDateOfInspection();

        if(null !== $dateOfInspection)
        {
            $dateOfInspection = [
                $dateOfInspection->format('j'),
                $dateOfInspection->format('n'),
                $dateOfInspection->format('Y')
            ];
        }
        else
        {
            $dateOfInspection = [];
        }

        $dateOfOilChange = $vehicle->getDateOfOilChange();

        if(null !== $dateOfOilChange)
        {
            $dateOfOilChange = [
                $dateOfOilChange->format('j'),
                $dateOfOilChange->format('n'),
                $dateOfOilChange->format('Y')
            ];
        }
        else
        {
            $dateOfOilChange = [];
        }

        return new JsonResponse([$vehicleArray, $brandName, $modelName, $dateOfInspection, $dateOfOilChange]);
    }
}