<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:13 PM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkstationController extends Controller
{
    public function indexAction()
    {

        return $this->render('HeaderBundle::measure.html.twig');
    }
}