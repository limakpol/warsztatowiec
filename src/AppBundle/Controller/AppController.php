<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/11/17
 * Time: 5:21 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AppController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle::index.html.twig');
    }

}