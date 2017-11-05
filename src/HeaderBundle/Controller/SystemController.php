<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/25/17
 * Time: 2:51 PM
 */

namespace HeaderBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SystemController extends Controller
{
    public function indexAction()
    {
        return $this->render('HeaderBundle::system.html.twig');
    }

    public function generateTestDataAction()
    {
        $previousDataRemover = $this->get('app.previous_data_remover');
        $testDataGenerator = $this->get('app.test_data_generator');

        $previousDataRemover->removePreviousData();
        $testDataGenerator->generateData();

        return new Response();
    }
}