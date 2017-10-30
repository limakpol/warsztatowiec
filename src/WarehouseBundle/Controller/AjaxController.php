<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/28/17
 * Time: 3:26 AM
 */

namespace WarehouseBundle\Controller;


use AppBundle\Entity\CarModel;
use AppBundle\Entity\Category;
use AppBundle\Entity\Good;
use AppBundle\Entity\Indexx;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AjaxController extends Controller
{

    public function getSelectableCategoriesAction()
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

    public function getSelectableModelsAction()
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
}