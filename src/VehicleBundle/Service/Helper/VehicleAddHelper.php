<?php

namespace VehicleBundle\Service\Helper;

use AppBundle\Entity\CarBrand;
use AppBundle\Entity\CarModel;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Service\Trade\Trade;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use HeaderBundle\Service\Helper\Crud\CarBrandHelper;
use HeaderBundle\Service\Helper\Crud\CarModelHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use VehicleBundle\Form\VehicleType;

class VehicleAddHelper
{
    private $requestStack;
    private $tokenStorage;
    private $formFactory;
    private $entityManager;
    private $container;
    private $carBrandHelper;
    private $carModelHelper;
    private $trade;

    public function __construct(RequestStack $requestStack, TokenStorageInterface $tokenStorage, FormFactoryInterface $formFactory, EntityManagerInterface $entityManager, ContainerInterface $container, CarBrandHelper $carBrandHelper, CarModelHelper $carModelHelper, Trade $trade)
    {
        $this->requestStack     = $requestStack;
        $this->tokenStorage     = $tokenStorage;
        $this->formFactory      = $formFactory;
        $this->entityManager    = $entityManager;
        $this->container        = $container;
        $this->carBrandHelper   = $carBrandHelper;
        $this->carModelHelper   = $carModelHelper;
        $this->trade            = $trade;
    }

    public function createAddForm()
    {
        $vehicle = new Vehicle();

        $form = $this->formFactory->create(VehicleType::class, $vehicle, [
            'validation_groups' => ['vehicle']
        ]);

        return $form;
    }

    public function isValid(Form $form)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        if($request->isMethod('POST'))
        {
            $form->submit($request->request->get($form->getName()));

            return $form->isValid();
        }

        return false;
    }

    public function write(Form $form)
    {
        /** @var Request $request */
        $request = $this->requestStack->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var Vehicle $vehicle */
        $vehicle = $form->getData();

        $dateTime = new \DateTime();

        $brandName = $request->get('vehicle')['car_brand'];
        $modelName = $request->get('vehicle')['car_model'];

        /** @var CarModel $model */
        $model = $this->getModel($brandName, $modelName);

        $vehicle->setCarModel($model);

        $vehicle = $this->evaluateTradeValues($vehicle);

        $vehicle->setCreatedAt($dateTime);
        $vehicle->setCreatedBy($user);
        $vehicle->setUpdatedBy($user);
        $vehicle->setWorkshop($workshop);

        $em->persist($vehicle);

        $em->flush();

        return $vehicle->getId();
    }

    public function evaluateTradeValues(Vehicle $vehicle)
    {
        $engineDisplacementL = $vehicle->getEngineDisplacementL();

        if(null !== $engineDisplacementL)
        {
            $engineDisplacementL = $this->trade->normalize($engineDisplacementL);

            if ($engineDisplacementL > 50) {
                $vehicle->setEngineDisplacementCm3($engineDisplacementL);

                $engineDisplacementL = round($engineDisplacementL / 1000, 1);

                $vehicle->setEngineDisplacementL($engineDisplacementL);
            } else {
                $vehicle->setEngineDisplacementL($engineDisplacementL);

                $engineDisplacementCm3 = 1000 * $engineDisplacementL;

                $vehicle->setEngineDisplacementCm3($engineDisplacementCm3);
            }
        }

        $enginePowerKm = $vehicle->getEnginePowerKm();

        if(null !== $enginePowerKm)
        {
            $enginePowerKm = $this->trade->normalize($enginePowerKm);

            $vehicle->setEnginePowerKm($enginePowerKm);

            $enginePowerKw = 0.73549875 * $enginePowerKm;

            $vehicle->setEnginePowerKw($enginePowerKw);
        }

        return $vehicle;
    }


    public function getModel($brandName, $modelName)
    {

        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $brand = $em->getRepository('AppBundle:CarBrand')->getOneByName($workshop, $brandName);

        if(null === $brand)
        {
            /** @var CarBrand $brand */
            $brand = $em->getRepository('AppBundle:CarBrand')->getOneRemovedByName($workshop, $brandName);

            if(null === $brand)
            {
                $brand = new CarBrand();
                $brand->setWorkshop($workshop);
                $brand->setCreatedAt(new \DateTime());
                $brand->setCreatedBy($user);
                $brand->setUpdatedBy($user);
                $brand->setName($brandName);
                
                $em->persist($brand);
                
                $model = $this->createModel($brand, $user, $modelName);

                $em->persist($model);

                return $model;
            }
            else
            {
                $brand = $this->setNull($brand);

                $em->persist($brand);

                return $this->generateModel($user, $brand, $modelName);
            }
        }
        else
        {
            return $this->generateModel($user, $brand, $modelName);
        }
    }
    
    public function createModel(CarBrand $brand, User $user, $modelName)
    {
        $model = new CarModel();
        $model->setBrand($brand);
        $model->setName($modelName);
        $model->setCreatedBy($user);
        $model->setCreatedAt(new \DateTime());
        $model->setUpdatedBy($user);

        return $model;
    }
    
    public function setNull($entity)
    {
        $entity->setRemovedAt(null);
        $entity->setRemovedBy(null);
        $entity->setDeletedBy(null);
        $entity->setDeletedAt(null);

        return $entity;
    }

    public function generateModel(User $user, CarBrand $brand, $modelName)
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $model = $em->getRepository('AppBundle:CarModel')->getOneByName($workshop, $modelName);

        if($brand->getModels()->contains($model))
        {
            return $model;
        }

        /** @var CarModel $model */
        $model = $em->getRepository('AppBundle:CarModel')->getOneRemovedByName($workshop, $modelName);

        if($brand->getModels()->contains($model))
        {
            $model = $this->setNull($model);

            $em->persist($model);

            return $model;
        }

        $model = $this->createModel($brand, $user, $modelName);

        $em->persist($model);

        return $model;
    }
    
}
