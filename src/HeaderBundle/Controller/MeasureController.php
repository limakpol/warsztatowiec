<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:11 PM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MeasureController extends Controller
{
    public function indexAction()
    {

        return $this->render('HeaderBundle::measure.html.twig');
    }
}