<?php

namespace CustomerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CustomerController extends Controller
{

    public function indexAction()
    {

        return $this->render('CustomerBundle::index.html.twig');
    }

    public function addAction()
    {

        return $this->render('CustomerBundle::add.html.twig');
    }
}