<?php


namespace AppBundle\Command;

use AppBundle\Entity\Province;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GenerateProvinces extends Command
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
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
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $provinces = $em->getRepository('AppBundle:Province')->findAll();

        if(!$provinces)
        {
            $provinceNames = $this->container->getParameter('pl')['provinces'];

            $this->writeProvinceNames($provinceNames);

            $output->writeln('All of provinces has been saved');
        }
        else
        {
            $output->writeln('Provinces already exist');
        }
    }

    private function writeProvinceNames(array $provinceNames)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        foreach ($provinceNames as $provinceName) {

            $province = new Province();

            $province->setName($provinceName);

            $em->persist($province);
        }

        $em->flush();
    }
}