<?php


namespace AppBundle\Command;

use AppBundle\Entity\Province;
use AppBundle\Service\Helper\ParameterContainer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateProvinces extends Command
{
    protected $entityManager;
    protected $parameterContainer;

    public function __construct(EntityManagerInterface $entityManager, ParameterContainer $parameterContainer)
    {
        $this->entityManager        = $entityManager;
        $this->parameterContainer   = $parameterContainer;

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
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $parameters = $this->parameterContainer->getAppParameters();

        $provinceNames = $parameters['provinces'];

        foreach ($provinceNames as $provinceName) {

            $province = new Province();

            $province->setName($provinceName);

            $em->persist($province);
        }

        $em->flush();
    }
}