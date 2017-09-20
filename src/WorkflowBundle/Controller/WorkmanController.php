<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 2:32 AM
 */

namespace WorkflowBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkmanController extends Controller
{
    public function indexAction()
    {

        return $this->render('WorkflowBundle:workman:index.html.twig');
    }

    public function addAction()
    {

        return $this->render('WorkflowBundle:workman:add.html.twig');
    }
}