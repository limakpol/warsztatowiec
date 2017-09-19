<?php

namespace HeaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HeaderController extends Controller
{
    public function indexAction()
    {

        return $this->render('HeaderBundle::index.html.twig');
    }
}