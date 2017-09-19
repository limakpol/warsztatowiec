<?php

namespace EmailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class EmailController extends Controller
{
    public function indexAction()
    {

        return $this->render('EmailBundle::index.html.twig');
    }
}