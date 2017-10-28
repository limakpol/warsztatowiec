<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 10/28/17
 * Time: 3:26 AM
 */

namespace WarehouseBundle\Controller;


use AppBundle\Entity\Category;
use AppBundle\Entity\Good;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{

    public function getSelectableModalAction()
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

}