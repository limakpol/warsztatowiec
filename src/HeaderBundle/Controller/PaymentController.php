<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:15 PM
 */

namespace HeaderBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PaymentController extends Controller
{
    public function indexAction()
    {

        return $this->render('HeaderBundle::payment.html.twig', [
            'error' => null,
        ]);
    }
}