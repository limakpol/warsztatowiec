<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/28/17
 * Time: 3:26 AM
 */

namespace WarehouseBundle\Controller;


use AppBundle\Entity\CarBrand;
use AppBundle\Entity\CarModel;
use AppBundle\Entity\Category;
use AppBundle\Entity\DeliveryDetail;
use AppBundle\Entity\Good;
use AppBundle\Entity\Indexx;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{

    public function selectableGetCategoriesAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $categories = $em->getRepository('AppBundle:Category')->retrieve($workshop);

        $goodId = $request->get('goodId');

        /** @var Good $good */
        $good = $em->getRepository('AppBundle:Good')->getOne($workshop, $goodId);

        $goodCategories = [];

        if(null !== $good)
        {
            $goodCategories = $em->getRepository('AppBundle:Category')->retrieveByGoodId($workshop, [$good->getId()]);
        }

        return $this->render('WarehouseBundle::category_selectable_modal_content.html.twig', [
            'categories' => $categories,
            'goodCategories' => $goodCategories,
        ]);
    }

    public function selectableGetModelsAction()
    {

        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $models = $em->getRepository('AppBundle:CarModel')->retrieve($workshop);

        $goodId = $request->get('goodId');

        /** @var Good $good */
        $good = $em->getRepository('AppBundle:Good')->getOne($workshop, $goodId);

        $goodModels = [];

        if(null !== $good)
        {
            $goodModels = $em->getRepository('AppBundle:CarModel')->retrieveByGoodId($workshop, [$good->getId()]);
        }

        return $this->render('WarehouseBundle::model_selectable_modal_content.html.twig', [
            'models' => $models,
            'goodModels' => $goodModels,
        ]);
    }

    public function selectableAddCategoryAction()
    {

        $categoryHelper = $this->get('header.helper.category');

        if(!$categoryHelper->isRequestCorrect())
        {
            return $categoryHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$categoryHelper->isValid())
        {
            return $categoryHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($categoryHelper->categoryExists())
        {
            return $categoryHelper->getErrorMessage('Taka kategoria już istnieje');
        }

        if(null !== ($category = $categoryHelper->categoryExistsRemoved()))
        {
            $categoryHelper->restore($category);

            return $this->selectableGetCategoriesAction();
        }

        $categoryHelper->write();

        return $this->selectableGetCategoriesAction();
    }

    public function selectableAddCarModelAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $brandName = $request->get('brand');
        $modelName = $request->get('model');

        if(!$request->isXmlHttpRequest() || !$request->isMethod('POST') || !$brandName || strlen($brandName) > 20 || !$modelName || strlen($modelName) > 20)
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => [
                    'Nieprawidłowe żądanie',
                ],
            ]);
        }

        /** @var CarBrand $brand */
        $brand = $em->getRepository('AppBundle:CarBrand')->getOneByName($workshop, $brandName);

        if(null === $brand)
        {
            $brand = new CarBrand();
            $brand->setWorkshop($workshop);
            $brand->setName($brandName);
            $brand->setCreatedBy(new \DateTime());
            $brand->setCreatedBy($user);
            $brand->setUpdatedBy($user);
        }

        /** @var CarModel $model */
        $model = $em->getRepository('AppBundle:CarModel')->getOneByName($workshop, $modelName);

        if(null === $model)
        {
            $model = new CarModel();
            $model->setName($modelName);
            $model->setCreatedAt(new \DateTime());
            $model->setCreatedBy($user);
            $model->setUpdatedBy($user);
        }

        $model->setBrand($brand);

        $em->persist($model);
        $em->persist($brand);

        $em->flush();

        return $this->selectableGetModelsAction();
    }


    public function getOneGoodAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var Good $good */
        $good =  $em->getRepository('AppBundle:Good')
            ->getOne($workshop, $request->get('goodId'));

        if(null === $good)
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => ['Nie ma takiego towaru'],
            ]);
        }

        $categories = [];

        /** @var Category $category */
        foreach($good->getCategories() as $category)
        {
            $categories[] = [$category->getId(), $category->getName()];
        }

        $carModels = [];

        /** @var CarModel $carModel */
        foreach($good->getCarModels() as $carModel)
        {
            $carModels[] = [$carModel->getId(), $carModel->getBrand()->getName() . ' ' . $carModel->getName()];
        }

        $good = $em->getRepository('AppBundle:Good')->getOne($workshop, $good->getId(), Query::HYDRATE_ARRAY);

        return new JsonResponse([$good, $categories, $carModels]);
    }

    public function getOneIndexxAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var Indexx $indexx */
        $indexx =  $em->getRepository('AppBundle:Indexx')
            ->getOne($workshop, $request->get('indexxId'), Query::HYDRATE_ARRAY);

        if(null === $indexx)
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => ['Nie ma takiego indeksu'],
            ]);
        }

        return new JsonResponse($indexx);
    }

    public function addProducerAction()
    {
        $producerHelper = $this->get('warehouse.helper.producer');

        if(!$producerHelper->isRequestCorrect())
        {
            return $producerHelper->getErrorMessage('Nieprawidłowe żądanie');
        }

        if(!$producerHelper->isValid())
        {
            return $producerHelper->getErrorMessage('Wpisano nieprawidłowe dane');
        }

        if($producerHelper->producerExists())
        {
            return $producerHelper->getErrorMessage('Producent o takiej nazwie już istnieje');
        }

        if(null !== ($producer = $producerHelper->producerExistsRemoved()))
        {
            $producer = $producerHelper->recover($producer);

            return new JsonResponse([
                'errors' => 0,
                'producerId' => $producer->getId(),
                'producerName' => $producer->getName(),
            ]);
        }

        $producer = $producerHelper->write();

        return new JsonResponse([
            'errors' => 0,
            'producerId' => $producer->getId(),
            'producerName' => $producer->getName(),
        ]);
    }

    public function getLasPricesAction()
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();


        $deliveryDetails = $em
            ->getRepository('AppBundle:DeliveryDetail')
            ->getByIndexxId($workshop, $request->get('indexxId'));

        $prices = [];

        /** @var DeliveryDetail $deliveryDetail */
        foreach($deliveryDetails as $deliveryDetail)
        {
            if(($qty = $deliveryDetail->getQuantity()) > 0)
            {
                $price = round($deliveryDetail->getTotalDue()/$qty, 2);
                $shortcut = $deliveryDetail->getIndexx()->getGood()->getMeasure()->getShortcut();
                $headerId = $deliveryDetail->getDeliveryHeaderId();

                $prices[] = [$price, $shortcut, $headerId ];
            }
        }

        return $this->render('WarehouseBundle::last_prices_content.html.twig', [
            'prices' => $prices,
        ]);
    }

}