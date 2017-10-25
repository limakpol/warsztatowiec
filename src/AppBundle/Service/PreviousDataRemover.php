<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/25/17
 * Time: 3:29 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Action;
use AppBundle\Entity\Address;
use AppBundle\Entity\CarBrand;
use AppBundle\Entity\CarModel;
use AppBundle\Entity\Category;
use AppBundle\Entity\Customer;
use AppBundle\Entity\DeliveryHeader;
use AppBundle\Entity\Good;
use AppBundle\Entity\Groupp;
use AppBundle\Entity\Indexx;
use AppBundle\Entity\IndexxEdit;
use AppBundle\Entity\Measure;
use AppBundle\Entity\Model;
use AppBundle\Entity\OrderHeader;
use AppBundle\Entity\OrderIndexx;
use AppBundle\Entity\Position;
use AppBundle\Entity\Producer;
use AppBundle\Entity\SaleDetail;
use AppBundle\Entity\SaleHeader;
use AppBundle\Entity\Status;
use AppBundle\Entity\User;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\Workshop;
use AppBundle\Entity\Workstation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use ServiceBundle\ServiceBundle;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PreviousDataRemover
{
    private $entityManager;
    private $tokenStorage;

    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager    = $entityManager;
        $this->tokenStorage     = $tokenStorage;
    }

    public function removePreviousData()
    {
        $this->removeServices();
        $this->removeActions();
        $this->removeCategories();
        $this->removeDeliveries();
        $this->removeSales();
        $this->removeVehicles();
        $this->removeCustomers();
        $this->removeGoods();
        $this->removeGroupps();
        $this->removeMeasures();
        $this->removeBrands();
        $this->removeOrders();
        $this->removePositions();
        $this->removeProducers();
        $this->removeStatuses();
        $this->removeWorkstations();

        return;
    }

    public function removeActions()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $actions = $em->getRepository('AppBundle:Action')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Action $action */
        foreach($actions as $action)
        {
            $em->remove($action);
        }

        $em->flush();

        return;
    }

    public function removeAddresses()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $addresses = $em->getRepository('AppBundle:Address')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Address $address */
        foreach($addresses as $address)
        {
            $em->remove($address);
        }

        $em->flush();

        return;
    }

    public function removeCategories()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $categories = $em->getRepository('AppBundle:Category')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Category $category */
        foreach($categories as $category)
        {
            $em->remove($category);
        }

        $em->flush();

        return;
    }

    public function removeCustomers()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $customers = $em->getRepository('AppBundle:Customer')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Customer $customer */
        foreach($customers as $customer)
        {
            if(null !== $customer->getAddress())
            {
                $em->remove($customer->getAddress());
            }

            $em->remove($customer);
        }

        $em->flush();

        return;
    }

    public function removeDeliveries()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $deliveryHeaders = $em->getRepository('AppBundle:DeliveryHeader')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var DeliveryHeader $deliveryHeader */
        foreach($deliveryHeaders as $deliveryHeader)
        {
            foreach($deliveryHeader->getDeliveryDetails() as $deliveryDetail)
            {
                $em->remove($deliveryDetail);
            }

            $em->remove($deliveryHeader);
        }

        $em->flush();

        return;
    }

    public function removeGoods()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $goods = $em->getRepository('AppBundle:Good')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Good $good */
        foreach($goods as $good)
        {
            /** @var Indexx $indexx */
            foreach($good->getIndexxes() as $indexx)
            {
                $indexxEdits = $em->getRepository('AppBundle:IndexxEdit')->findBy([
                    'workshop' => $workshop,
                    'indexx'    => $indexx,
                ]);

                /** @var IndexxEdit $indexxEdit */
                foreach($indexxEdits as $indexxEdit)
                {
                    $em->remove($indexxEdit);
                }

                $em->remove($indexx);
            }

            $em->remove($good);
        }

        $em->flush();

        return;
    }

    public function removeGroupps()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $groupps = $em->getRepository('AppBundle:Groupp')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Groupp $groupp */
        foreach($groupps as $groupp)
        {
            $em->remove($groupp);
        }

        $em->flush();

        return;
    }

    public function removeMeasures()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $measures = $em->getRepository('AppBundle:Measure')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Measure $measure */
        foreach($measures as $measure)
        {
            $em->remove($measure);
        }

        $em->flush();

        return;
    }

    public function removeBrands()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $brands = $em->getRepository('AppBundle:CarBrand')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var CarBrand $brand */
        foreach($brands as $brand)
        {
            foreach($brand->getModels() as $model)
            {
                $em->remove($model);
            }

            $em->remove($brand);
        }

        $em->flush();

        return;
    }


    public function removeOrders()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $orderHeaders = $em->getRepository('AppBundle:OrderHeader')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var OrderHeader $orderHeader */
        foreach($orderHeaders as $orderHeader)
        {
            foreach($orderHeader->getFaults() as $fault)
            {
                $em->remove($fault);
            }

            foreach($orderHeader->getSymptoms() as $symptom)
            {
                $em->remove($symptom);
            }

            foreach($orderHeader->getOrderServices() as $orderService)
            {
                $em->remove($orderService);
            }

            /** @var OrderIndexx $orderIndexx */
            foreach($orderHeader->getOrderIndexxes() as $orderIndexx)
            {
                foreach($orderIndexx->getOrderActions() as $orderAction)
                {
                    $em->remove($orderAction);
                }

                $em->remove($orderIndexx);
            }

            $em->remove($orderHeader);
        }

        $em->flush();

        return;
    }

    public function removePositions()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $positions = $em->getRepository('AppBundle:Position')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Position $position */
        foreach($positions as $position)
        {
            $em->remove($position);
        }

        $em->flush();

        return;
    }

    public function removeProducers()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $producers = $em->getRepository('AppBundle:Producer')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Producer $producer */
        foreach($producers as $producer)
        {
            $em->remove($producer);
        }

        $em->flush();

        return;
    }

    public function removeSales()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $saleHeaders = $em->getRepository('AppBundle:SaleHeader')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var SaleHeader $saleHeader */
        foreach($saleHeaders as $saleHeader)
        {
            /** @var SaleDetail $saleDetail */
            foreach($saleHeader->getSaleDetails() as $saleDetail)
            {
                $em->remove($saleDetail);
            }

            $em->remove($saleHeader);
        }

        $em->flush();

        return;
    }

    public function removeServices()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $services = $em->getRepository('AppBundle:Service')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var ServiceBundle $service */
        foreach($services as $service)
        {
            $em->remove($service);
        }

        $em->flush();

        return;
    }

    public function removeStatuses()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $statuses = $em->getRepository('AppBundle:Status')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Status $status */
        foreach($statuses as $status)
        {
            $em->remove($status);
        }

        $em->flush();

        return;
    }

    public function removeVehicles()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $vehicles = $em->getRepository('AppBundle:Vehicle')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Vehicle $vehicle */
        foreach($vehicles as $vehicle)
        {
            $em->remove($vehicle);
        }

        $em->flush();

        return;
    }

    public function removeWorkstations()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $workstations = $em->getRepository('AppBundle:Workstation')->findBy([
            'workshop' => $workshop,
        ]);

        /** @var Workstation $workstation */
        foreach($workstations as $workstation)
        {
            $em->remove($workstation);
        }

        $em->flush();

        return;
    }


}