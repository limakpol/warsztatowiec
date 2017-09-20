<?php

namespace SaleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SaleController extends Controller
{
    public function indexAction()
    {

        return $this->render('SaleBundle:header:index.html.twig');
    }

    public function addAction()
    {

        return $this->render('SaleBundle:header:add.html.twig');
    }
}
