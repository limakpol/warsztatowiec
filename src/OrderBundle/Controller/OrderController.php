<?php

namespace OrderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class OrderController extends Controller
{
    public function indexAction()
    {

        return $this->render('OrderBundle::index.html.twig');
    }
}