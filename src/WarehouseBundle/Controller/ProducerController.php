<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 2:27 AM
 */

namespace WarehouseBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProducerController extends Controller
{

    public function indexAction()
    {

        return $this->render('WarehouseBundle:producer:index.html.twig');
    }
}