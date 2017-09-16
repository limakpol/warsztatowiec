<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/16/17
 * Time: 10:46 PM
 */

namespace AppBundle\Command;


use AppBundle\Service\Helper\YamlParser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class TruncateAllTables extends Command
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
            ->setName('app:truncate:all-tables')
            ->setDescription('Truncate all tables');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = $this->entityManager->getConnection();

        $sql = 'SET foreign_key_checks = 0;';

        $connection->query($sql)->execute();

        $tables = $this->yamlParser->getTableNames();

        foreach($tables as $table)
        {
            $sql = 'TRUNCATE TABLE `' . $table . '`';

            $connection->query($sql)->execute();

            $msg = 'Table ' . $table . ' has been truncated';

            $output->writeln($msg);
        }
    }
}