<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/16/17
 * Time: 6:48 PM
 */

namespace AppBundle\Command;

use AppBundle\Service\Helper\YamlParser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdatedAt extends Command
{
    protected $entityManager;
    protected $yamlParser;

    public function __construct(EntityManagerInterface $entityManager, YamlParser $yamlParser)
    {
        $this->entityManager    = $entityManager;
        $this->yamlParser       = $yamlParser;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:updated-at')
            ->setDescription('Change updated_at in all tables to timestamp')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $schemas =  $this->yamlParser->getSchemas();

        foreach($schemas as $schema)
        {
            $this->changeUpdatedAt($schema, $output);
        }
    }

    private function changeUpdatedAt($schema, $output)
    {
        $connection = $this->entityManager->getConnection();

        foreach($schema as $index)
        {
            if(isset($index['fields']['updated_at']))
            {
                $sql = 'ALTER TABLE `' . $index['table'] . '` CHANGE `updated_at` `updated_at` timestamp NOT NULL DEFAULT \'0000-00-00\' ON UPDATE CURRENT_TIMESTAMP AFTER `created_at`';

                $dbh = $connection->query($sql)->execute();

                $this->message($index['table'], $output);

            }
        }
    }

    private function message($tableName, $output)
    {
        $msg = 'Changed updated_at to timestamp in table ' . $tableName;

        $output->writeln($msg);
    }
}