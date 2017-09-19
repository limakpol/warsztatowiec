<?php

namespace StorageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class StorageController extends Controller
{
    public function indexAction()
    {

        return $this->render('StorageBundle::index.html.twig');
    }
}