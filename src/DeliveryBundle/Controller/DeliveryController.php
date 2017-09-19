<?php

namespace DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeliveryController extends Controller
{
    public function indexAction()
    {

        return $this->render('DeliveryBundle::index.html.twig');
    }
}