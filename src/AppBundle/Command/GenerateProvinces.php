<?php


namespace AppBundle\Command;

use AppBundle\Entity\Province;
use AppBundle\Service\ParameterContainer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GenerateProvinces extends Command
{
    protected $entityManager;
    protected $container;

    public function __construct(EntityManagerInterface $entityManager, ContainerInterface $container)
    {
        $this->entityManager        = $entityManager;
        $this->container            = $container;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:generate:provinces')
            ->setDescription('Copy provinces from parameters to table')
        ;

    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $provinces = $this->entityManager->getRepository('AppBundle:Province')->findAll();

        if(!$provinces)
        {

            $this->writeProvinceNames();

            $output->writeln('All of provinces has been saved');
        }
        else
        {
            $output->writeln('Provinces already exist');
        }

    }

    private function writeProvinceNames()
    {
        $em = $this->entityManager;

        $provinceNames = $this->container->getParameter('app')['provinces'];

        foreach ($provinceNames as $provinceName) {

            $province = new Province();

            $province->setName($provinceName);

            $em->persist($province);
        }

        $em->flush();
    }
}