<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:13 PM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PositionController extends Controller
{
    public function indexAction()
    {

        return $this->render('HeaderBundle::position.html.twig', [
            'error' => null,
        ]);
    }
}