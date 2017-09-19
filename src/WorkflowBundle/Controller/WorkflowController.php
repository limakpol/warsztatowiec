<?php

namespace WorkflowBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkflowController extends Controller
{
    public function indexAction()
    {

        return $this->render('WorkflowBundle::index.html.twig');
    }
}