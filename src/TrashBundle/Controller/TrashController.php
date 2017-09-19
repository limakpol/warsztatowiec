<?php

namespace TrashBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TrashController extends Controller
{
    public function indexAction()
    {

        return $this->render('TrashBundle::index.html.twig');
    }
}