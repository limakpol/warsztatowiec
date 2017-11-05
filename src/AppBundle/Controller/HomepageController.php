<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/12/17
 * Time: 9:34 AM
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomepageController extends Controller
{
    public function indexAction()
    {

        return $this->render('AppBundle:homepage:index.html.twig');
    }
}