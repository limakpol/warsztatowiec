<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 2:30 AM
 */

namespace ServiceBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ActionController extends Controller
{

    public function indexAction()
    {

        return $this->render('ServiceBundle:action:index.html.twig');
    }
}