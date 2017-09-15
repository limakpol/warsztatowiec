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

        if(!$provinces) {

            $configProvinces = $this->container->getParameter('pl')['provinces'];

            foreach ($configProvinces as $configProvince) {
                $province = new Province();
                $province->setName($configProvince);
                $em->persist($province);
            }

            $em->flush();
        }
    }

}