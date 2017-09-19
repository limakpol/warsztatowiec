<?php

namespace WarehouseBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WarehouseController extends Controller
{
    public function indexAction()
    {

        return $this->render('WarehouseBundle::index.html.twig');
    }
}