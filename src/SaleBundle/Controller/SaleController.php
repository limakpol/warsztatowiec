<?php

namespace SaleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SaleController extends Controller
{
    public function indexAction()
    {

        return $this->render('SaleBundle::index.html.twig');
    }
}