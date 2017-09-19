<?php

namespace InvoiceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InvoiceController extends Controller
{
    public function indexAction()
    {

        return $this->render('InvoiceBundle::index.html.twig');
    }
}