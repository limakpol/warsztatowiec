<?php

namespace SmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SmsController extends Controller
{
    public function indexAction()
    {

        return $this->render('SmsBundle::index.html.twig');
    }
}