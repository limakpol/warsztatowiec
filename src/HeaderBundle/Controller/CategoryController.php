<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/24/17
 * Time: 5:53 AM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{
    public function indexAction()
    {
        return $this->render('HeaderBundle::category.html.twig');
    }
}