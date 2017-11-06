<?php

namespace CustomerBundle\Controller;

use AppBundle\Entity\Address;
use AppBundle\Entity\Customer;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use EmailBundle\Service\Message;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends Controller
{

    public function indexAction()
    {
        $indexHelper = $this->get('customer.helper.index');

        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $customers  = $indexHelper->retrieve($sortableParameters);
        $groupps    = $indexHelper->retrieveGroupps();
        $limitSet   = $this->getParameter('app')['limit_set'];

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();


        return $this->render('CustomerBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Klienci',
            'customers'     => $customers,
            'groupps'       => $groupps,
            'limitSet'      => $limitSet,
            'sortableParameters' => $sortableParameters,
        ]);
    }

    public function retrieveAction()
    {
        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        if(!$request->isMethod('POST') || !$request->isXmlHttpRequest())
        {
            return new JsonResponse([
                'error' => 1,
                'messages' => ['Nieprawidłowe żądanie'],
            ]);
        }

        $indexHelper = $this->get('customer.helper.index');
        $inputSortableParameters = $indexHelper->getInputSortableParameters();
        $outputSortableParameters = $indexHelper->getOutputSortableParameters($inputSortableParameters);
        $sortableParameters = array_merge($inputSortableParameters, $outputSortableParameters);

        $customers  = $indexHelper->retrieve($sortableParameters);

        $groupps    = $indexHelper->retrieveGroupps();
        $limitSet   = $this->getParameter('app')['limit_set'];

        return $this->render('CustomerBundle::sortable_content.html.twig', [
            'customers' => $customers,
            'groupps' => $groupps,
            'limitSet' => $limitSet,
            'sortableParameters' => $sortableParameters,
        ]);
    }

    public function showAction($customerId)
    {
        $customerShowHelper = $this->get('customer.helper.show');

        /** @var Customer $customer */
        $customer = $customerShowHelper->getCustomer($customerId);

        if(null === $customer)
        {
            return $this->redirectToRoute('customer_index');
        }

        $orderHeaders       = $customerShowHelper->getOrderHeaders($customer);
        $deliveryHeaders    = $customerShowHelper->getDeliveryHeaders($customer);
        $saleHeaders        = $customerShowHelper->getSaleHeaders($customer);

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();
        $mainMenu   = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::show.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Klient',
            'customer'      => $customer,
            'orderHeaders'  => $orderHeaders,
            'deliveryHeaders' => $deliveryHeaders,
            'saleHeaders'   => $saleHeaders,
        ]);
    }

    public function addAction()
    {

        $customerHelper = $this->get('customer.helper.add');

        $form = $customerHelper->createAddForm();

        if($customerHelper->isValid($form))
        {
            $customerHelper->write($form);

            return $this->redirectToRoute('customer_index');
        }

        $groupps = $customerHelper->retrieveGroupps();

        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::add.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Dodawanie nowego klienta',
            'form'          => $form->createView(),
            'groupps'       => $groupps,
        ]);
    }

    public function editAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Klienci',
        ]);
    }

    public function removeAction()
    {
        $headerMenu = $this->get('app.yaml_parser')->getHeaderMenu();

        $mainMenu = $this->get('app.yaml_parser')->getMainMenu();

        return $this->render('CustomerBundle::index.html.twig', [
            'headerMenu'    => $headerMenu,
            'mainMenu'      => $mainMenu,
            'tab'           => 'customer',
            'navbar'        => 'Klienci',
        ]);
    }

    public function getOneAction($hydrationMode = Query::HYDRATE_OBJECT)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        /** @var Request $request */
        $request = $this->get('request_stack')->getCurrentRequest();

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var Customer $customer */
        $customer =  $em->getRepository('AppBundle:Customer')
            ->getOne($workshop, $request->get('customerId'), $hydrationMode);

        /** @var Address $address */
        $address = $em->getRepository('AppBundle:Address')->getOne($customer['address_id'], $hydrationMode);

        if($hydrationMode == 2)
        {
            $groupps = $em->getRepository('AppBundle:Groupp')
                ->retrieveByCustomerId($workshop, $customer['id']);
        }
        else
        {
            $groupps = $em->getRepository('AppBundle:Groupp')
                ->retrieveByCustomerId($workshop, $customer->getId(), 1);
        }

        return new JsonResponse([$customer, $address, $groupps]);
    }

    public function sendEventAction()
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        if($request->getHost() == 'www.local.warsztatowiec.pl' || $request->getHost() == 'local.warsztatowiec.pl') return;

        /** @var User $user */
        $user = $this->get('security.token_storage')->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        $mailer = $this->get('email.mailer');

        $userName = $user->getForename() . ' ' . $user->getSurname();

        $body = $this->render('AppBundle:mailing:customer_index_event.html.twig', [
            'date' => new \DateTime(),
            'userName' => $userName,
            'workshopName' => $workshop->getName(),
            'email' => $user->getEmail(),
            'phone' => $user->getPhone1(),
        ]);

        $message = new Message();

        $message->setTo('kontakt@warsztatowiec.pl');
        $message->setSubject('Użytkownik wszedł na stronę klientów');
        $message->setBody($body);

        $mailer->send($message);
    }
}