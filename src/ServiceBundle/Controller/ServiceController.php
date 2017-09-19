<?php

namespace ServiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ServiceController extends Controller
{
    public function indexAction()
    {

        return $this->render('ServiceBundle::index.html.twig');
    }
}