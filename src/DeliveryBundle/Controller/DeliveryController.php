<?php

namespace DeliveryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DeliveryController extends Controller
{
    public function indexAction()
    {

        return $this->render('DeliveryBundle:header:index.html.twig');
    }

    public function addAction()
    {

        return $this->render('DeliveryBundle:header:add.html.twig');
    }
}