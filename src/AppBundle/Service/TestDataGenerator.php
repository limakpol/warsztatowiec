<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/25/17
 * Time: 1:30 PM
 */

namespace AppBundle\Service;

use AppBundle\Entity\Action;
use AppBundle\Entity\Address;
use AppBundle\Entity\CarBrand;
use AppBundle\Entity\CarModel;
use AppBundle\Entity\Category;
use AppBundle\Entity\Customer;
use AppBundle\Entity\Groupp;
use AppBundle\Entity\Measure;
use AppBundle\Entity\Model;
use AppBundle\Entity\Position;
use AppBundle\Entity\Producer;
use AppBundle\Entity\Status;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use AppBundle\Entity\Workstation;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TestDataGenerator
{
    private $entityManager;
    private $tokenStorage;

    const UPPERCASES    = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'W', 'X', 'Y', 'Z'];
    const LOWERCASES     = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'w', 'x', 'y', 'z'];
    const NUMBERS       = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
    const TIMESTAMP_01_01_2014 = 1388530801;
    const TIMESTAMP_31_12_2016 = 1483223400;

    const FORENAMES = [
        'Michał',       'Daniel',       'Paweł',        'Piotr',        'Kamil',
        'Tomasz',       'Grzegorz',     'Mariusz',      'Franciszek',   'Donald',
        'Ryszard',      'Władysław',    'Jarosław',     'Leszek',       'Filip',
        'Dawid',        'Robert',       'Ignacy',       'Ziemowit',     'Radosław',
        'Stanisław',    'Zdzisław',     'Cezary'
    ];

    const SURNAMES1 = ['Male', 'Kale', 'Abe', 'Wro', 'Poli', 'Glu', 'Wro', 'So', 'Klu', 'War', 'Wac', 'Łach', 'Tar'];
    const SURNAMES2 = ['bo', 'ro', 'do', 'so', 'ko', 'po', 're', 'de', 'da', 'ba', 'ma', 'mo', 'ła'];
    const SURNAMES3 = ['ński', 'wski', 'wicz', 'rski', 'wacz', 'mski'];

    const COMPANIES = ['Abc Sp.z.o.o.', 'XYZ S.A.', 'TTT Sp.z.o.o.', 'EQGH S.A', 'KMNB S.A', 'WQTB Sp.z.o.o.', 'VBNED S.A', 'DSFG Sp.z.o.o.', 'UKNV S.A'];

    const PRODUCERS = [
        '4MAX',     'ADVANTI',  'BOSCH',    'CARTECHNIC',   'DONALDSON',    'ELF',
        'FLORIMEX', 'Gumtech',  'HEPU',     'INTERSTATE',   'JURID',        'KANACO',
        'LAUFENN',  'MAHLE',    'NEXUS',    'OPTIMA',       'PASCAL',       'RONAL',
        'SASIC',    'TEAMEC',   'VIGNAL',   'ZAVOLI'
    ];

    const CATEGORIES = ['świece', 'wyposażenie', 'akumulatory', 'klocki hamulcowe', 'układ kierowniczy', 'płyny do wymiany'];

    const DOCUMENTS =  ["faktura", "paragon", "wydanie z magazynu", "asygnata"];

    const GOOD_MEASURES = [
        ["sztuka", "szt."], ["metr", "m"], ["metr bieżący", "m b."],
        ["kilogram", "kg"], ["litr", "l"], ["opakowanie", "opak."],
        ["komplet", "kpl."]
    ];

    const SERVICE_MEASURES = [["roboczogodzina", "rg."]];

    const ENGINE_TYPES = ["benzyna", "benzyna + gaz", "diesel", "hybryda", "EE"];

    const STATUSES = [
        ["przyjęte", "#00ff00"],    ["diagnoza", "#3399ff"],    ["oczekuje na części", "#993333" ],
        ["w toku", "#006600"],      ["odłożone", "#9999ff" ],   ["przerwa", "#ff0066" ],
        ["naprawione", "#ffff00"],
    ];

    const ACTIONS = [
        "wymiana",          "zmiana",           "przegląd",         "regulacja",        "naprawa",
        "montaż",           "demontaż",         "usunięcie",        "sprawdzenie",      "robocizna",
        "spawanie",         "lutowanie",        "uszczelnienie",    "programowanie",    "ustawienie",
        "regeneracja",      "wyczyszczenie",    "dezynfekcja",
    ];

    const WORKSTATIONS  = ['stanowisko naprawcze 1', 'stanowisko naprawcze 2', 'stanowisko naprawcze 3', 'stanowisko naprawcze 4'];

    const POSITIONS     =  ['administrator aplikacji', 'mechanik', 'obsługa klienta', 'kierownik'];

    const WAREHOUSE_DOCUMENTS =  ["asygnata", "wydanie z magazynu"];

    const CUSTOMER_GROUPS = ["stali klienci", "VIP-y", "flotowi", "niepłacący"];

    const MODELS = [
        [
            'name' => 'Citroen',
            'models' => ["Berlingo", "Jumper", "Xsara"],
        ],
        [
            'name' => 'Daewoo',
            'models' => ["Espero", "Lanos", 'Leganza', "Matiz", "Nexia", "Nubira", "Tico"],
        ],
        [
            'name' => 'Ford',
            'models' => ["Escort", "Fiesta", "Focus", "Fusion", "Ka", "Mondeo", "Scorpio", "Transit", "Sierra"],
        ],
        [
            'name' => 'Honda',
            'models' => ["Accord", "Civic"],
        ],
        [
            'name' => 'Hyundai',
            'models' => ["Accent", "Atos", "Pony"],
        ],
        [
            'name' => 'Mitsubishi',
            'models' => ["Carisma", "Colt", "Lancer", "Outlander", "Pajero"],
        ],
        [
            'name' => 'Fiat',
            'models' => ["Brava", "Cinquecento", "Ducato", "Palio", "Panda", "Punto", "Seicento", "Stilo"],
        ],
        [
            'name' => 'Opel',
            'models' => ["Astra", "Corsa", "Kadett", "omega", "Vectra", "Zafira"],
        ],
        [
            'name' => 'Renault',
            'models' => ["Clio", "Espace", "Kangoo", "Laguna", "Megane", "Twingo"],
        ],
        [
            'name' => 'Skoda',
            'models' => ["Fabia", "Felicia", "Octavia", "Rapid", "Superb"],
        ],
        [
            'name' => 'Subaru',
            'models' => ["Impreza"],
        ],
        [
            'name' => 'Toyota',
            'models' => ["Aygo", "Auris", "Avensis", "Corolla", "Previa", "Yaris"],
        ],
    ];


    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager    = $entityManager;
        $this->tokenStorage     = $tokenStorage;
    }

    public function generateData()
    {
        $this->generateActions();
        $this->generateCategories();
        $this->generateGroupps();
        $this->generateMeasures();
        $this->generateProducers();
        $this->generateStatuses();
        $this->generatePositions();
        $this->generateWorkstations();
        $this->generateModels();
        $this->generateCustomers();

        return;
    }

    public function generateActions()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        foreach($this::ACTIONS as $actionName)
        {
            $action = new Action();
            $action->setWorkshop($workshop);
            $action->setCreatedBy($user);
            $action->setUpdatedBy($user);
            $action->setCreatedAt(new \DateTime());
            $action->setName($actionName);

            $em->persist($action);
        }

        $em->flush();

        return;
    }

    public function generateCategories()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        foreach($this::CATEGORIES as $categoryName)
        {
            $category = new Category();
            $category->setWorkshop($workshop);
            $category->setCreatedBy($user);
            $category->setUpdatedBy($user);
            $category->setCreatedAt(new \DateTime());
            $category->setName($categoryName);

            $em->persist($category);
        }

        $em->flush();

        return;
    }

    public function generateGroupps()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        foreach($this::CUSTOMER_GROUPS as $grouppName)
        {
            $groupp = new Groupp();
            $groupp->setWorkshop($workshop);
            $groupp->setCreatedBy($user);
            $groupp->setUpdatedBy($user);
            $groupp->setCreatedAt(new \DateTime());
            $groupp->setName($grouppName);

            $em->persist($groupp);
        }

        $em->flush();

        return;
    }

    public function generateMeasures()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        foreach($this::GOOD_MEASURES as $measureName)
        {
            $measure = new Measure();
            $measure->setWorkshop($workshop);
            $measure->setCreatedBy($user);
            $measure->setUpdatedBy($user);
            $measure->setCreatedAt(new \DateTime());
            $measure->setTypeOfQuantity('good');
            $measure->setName($measureName[0]);
            $measure->setShortcut($measureName[1]);

            $em->persist($measure);
        }

        foreach($this::SERVICE_MEASURES as $measureName)
        {
            $measure = new Measure();
            $measure->setWorkshop($workshop);
            $measure->setCreatedBy($user);
            $measure->setUpdatedBy($user);
            $measure->setCreatedAt(new \DateTime());
            $measure->setTypeOfQuantity('service');
            $measure->setName($measureName[0]);
            $measure->setShortcut($measureName[1]);

            $em->persist($measure);
        }

        $em->flush();

        return;
    }

    public function generateProducers()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        foreach($this::PRODUCERS as $producerName)
        {
            $producer = new Producer();
            $producer->setWorkshop($workshop);
            $producer->setCreatedBy($user);
            $producer->setUpdatedBy($user);
            $producer->setCreatedAt(new \DateTime());
            $producer->setName($producerName);

            $em->persist($producer);
        }

        $em->flush();

        return;
    }

    public function generateStatuses()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        foreach($this::STATUSES as $statusName)
        {
            $status = new Status();
            $status->setWorkshop($workshop);
            $status->setCreatedBy($user);
            $status->setUpdatedBy($user);
            $status->setCreatedAt(new \DateTime());
            $status->setName($statusName[0]);
            $status->setHexColor($statusName[1]);

            $em->persist($status);
        }

        $em->flush();

        return;
    }

    public function generatePositions()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        foreach($this::POSITIONS as $positionName)
        {
            $position = new Position();
            $position->setWorkshop($workshop);
            $position->setCreatedBy($user);
            $position->setUpdatedBy($user);
            $position->setCreatedAt(new \DateTime());
            $position->setName($positionName);

            $em->persist($position);
        }

        $em->flush();

        return;
    }

    public function generateWorkstations()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        foreach($this::WORKSTATIONS as $workstationName)
        {
            $workstation = new Workstation();
            $workstation->setWorkshop($workshop);
            $workstation->setCreatedBy($user);
            $workstation->setUpdatedBy($user);
            $workstation->setCreatedAt(new \DateTime());
            $workstation->setName($workstationName);

            $em->persist($workstation);
        }

        $em->flush();

        return;
    }

    public function generateModels()
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        foreach($this::MODELS as $brandName)
        {
            $brand = new CarBrand();
            $brand->setWorkshop($workshop);
            $brand->setCreatedAt(new \DateTime());
            $brand->setCreatedBy($user);
            $brand->setUpdatedBy($user);
            $brand->setName($brandName['name']);
            
            
            foreach($brandName['models'] as $modelName)
            {
                $model = new CarModel();
                $model->setBrand($brand);
                $model->setCreatedAt(new \DateTime());
                $model->setCreatedBy($user);
                $model->setUpdatedBy($user);
                $model->setName($modelName);

                $em->persist($model);
            }
            
            $em->persist($brand);
        }

        $em->flush();

        return;
    }

    public function generateCustomers($customersCount = 234)
    {
        /** @var User $user */
        $user = $this->tokenStorage->getToken()->getUser();

        /** @var Workshop $workshop */
        $workshop = $user->getCurrentWorkshop();

        /** @var EntityManager $em */
        $em = $this->entityManager;

        $forenamesCount = count($this::FORENAMES);
        $surnames1Count = count($this::SURNAMES1);
        $surnames2Count = count($this::SURNAMES2);
        $surnames3Count = count($this::SURNAMES3);
        $companiesCount = count($this::COMPANIES);

        $provinces = $em->getRepository('AppBundle:Province')->findAll();
        $provincesCount = count($provinces);


        for($i = 0; $i < $customersCount; $i++)
        {
            $dateTime = new \DateTime();

            $customer = new Customer();
            $address = new Address();

            $address->setCreatedAt($dateTime);
            $address->setUpdatedBy($user);
            $address->setCreatedBy($user);

            $customer->setCreatedAt((new \DateTime())->setTimestamp(rand($this::TIMESTAMP_01_01_2014, $this::TIMESTAMP_31_12_2016)));
            $customer->setCreatedBy($user);
            $customer->setUpdatedBy($user);
            $customer->setWorkshop($workshop);
            $customer->setAddress($address);

            $forename = $this::FORENAMES[rand(0, $forenamesCount-1)];

            $customer->setForename($forename);

            $surname =      $this::SURNAMES1[rand(0, $surnames1Count-1)]
                        .   $this::SURNAMES2[rand(0, $surnames2Count-1)]
                        .   $this::SURNAMES3[rand(0, $surnames3Count-1)];

            $customer->setSurname($surname);

            $companyName = '';

            if(rand(0,2) == 0)
            {
                $companyName = $this::COMPANIES[rand(0, $companiesCount-1)];
                $customer->setCompanyName($companyName);
            }

            if(rand(0,9) > 2)
            {
                $prefix = '+48';

                if(rand(0,9) > 7)
                {
                    $prefix = '+' . $this->getNumber(2);
                }

                $customer->setMobilePhone1($prefix . $this->getNumber(9));
            }

            if(rand(0,9) > 4)
            {
                $prefix = '+48';

                if(rand(0,9) > 7)
                {
                    $prefix = '+' . $this->getNumber(2);
                }

                $customer->setMobilePhone2($prefix . $this->getNumber(9));
            }

            if(rand(0,9) > 4)
            {
                if($companyName == '')
                {
                    $domain = $this->getString(rand(5,15)) . '.pl';
                }
                else
                {
                    $domain = strtolower($companyName) . '.pl';
                }

                $email = strtolower($this->removePolishLetters($forename)) . '.' . strtolower($this->removePolishLetters($surname)) . '@' . str_replace(' ', '', $domain);

                $customer->setEmail($email);
            }

            $customer->setNip($this->getNumber(10));
            $customer->setPesel($this->getNumber(11));
            $customer->setBankAccountNumber($this->getNumber(26));
            $customer->setContactPerson($this->getString(rand(10,25)));
            $customer->setRemarks($this->getString(rand(100,200)));

            $address->setStreet($this->getString(rand(5,40)));
            $address->setHouseNumber($this->getNumber(rand(1,5)));
            $address->setFlatNumber($this->getNumber(rand(1,5)));
            $address->setPostCode($this->getPostCode());
            $address->setCity($this->getString(rand(8,25)));
            $address->setProvince($provinces[rand(0, $provincesCount-1)]);

            $em->persist($address);
            $em->persist($customer);
        }

        $em->flush();

        return;
    }

    public function getPostCode()
    {
        return $this->getNumber(2) . '-' . $this->getNumber(3);
    }

    public function getNumber($length, $maxMin = [1, 9])
    {
        $number = '';

        for ($i = 0; $i < $length; $i++) {
            $number .= rand($maxMin[0], $maxMin[1]);
        }

        return $number;
    }

    public function getString($length, $letter = 0)
    {
        $string = '';

        $countLower = count($this::LOWERCASES);
        $countUpper = count($this::UPPERCASES);

        if($letter == 0)
        {
            for($i=0; $i < $length; $i++)
            {
                $string .= $this::LOWERCASES[rand(0, $countLower-1)];
            }

            return $string;
        }

        if($letter == 1)
        {
            for($i=0; $i < $length; $i++)
            {
                $string .= $this::UPPERCASES[rand(0, $countUpper-1)];
            }

            return $string;
        }

        if($letter == 2)
        {
            $letters = array_merge($this::LOWERCASES, $this::UPPERCASES);
            $countLetters = count($letters);

            for($i=0; $i < $length; $i++)
            {
                $string .= $letters[rand(0, $countLetters-1)];
            }

            return $string;
        }
    }

    public function removePolishLetters($string)
    {
        $polish = ['ę', 'ó', 'ą', 'ś', 'ł', 'ż', 'ź', 'ć', 'ń', 'Ę', 'Ó', 'Ą', 'Ś', 'Ł', 'Ż', 'Ź', 'Ć', 'Ń'];

        $ascii = ['e', 'o', 'a', 's', 'l', 'z', 'z', 'c', 'n', 'E', 'O', 'A', 'S', 'L', 'Z', 'Z', 'C', 'N'];

        return str_replace($polish, $ascii, $string);
    }

}