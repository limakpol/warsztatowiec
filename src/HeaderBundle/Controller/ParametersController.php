<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/20/17
 * Time: 3:14 PM
 */

namespace HeaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ParametersController extends Controller
{
    public function indexAction()
    {

        $parametersHelper = $this->get('header.helper.parameters.index');

        $form = $parametersHelper->createForm();

        if($parametersHelper->isRequestCorrect())
        {
            if($parametersHelper->isValid($form))
            {
                return $parametersHelper->write($form);
            }

            return $parametersHelper->getErrors($form);
        }

        return $this->render('HeaderBundle::parameters.html.twig', [
            'error' => null,
            'form' => $form->createView(),
        ]);
    }
}
