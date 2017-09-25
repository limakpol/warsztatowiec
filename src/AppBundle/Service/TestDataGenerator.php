<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/25/17
 * Time: 1:30 PM
 */

namespace AppBundle\Service;


use AppBundle\Entity\Action;
use AppBundle\Entity\User;
use AppBundle\Entity\Workshop;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class TestDataGenerator
{
    private $entityManager;
    private $tokenStorage;

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



    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
    {
        $this->entityManager    = $entityManager;
        $this->tokenStorage     = $tokenStorage;
    }

}