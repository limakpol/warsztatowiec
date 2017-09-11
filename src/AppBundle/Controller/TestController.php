<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/11/17
 * Time: 5:17 PM
 */

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TestController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppBundle:test:index.html.twig');
    }

}