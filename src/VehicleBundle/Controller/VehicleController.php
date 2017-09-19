<?php

namespace VehicleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class VehicleController extends Controller
{
    public function indexAction()
    {

        return $this->render('VehicleBundle::index.html.twig');
    }
}