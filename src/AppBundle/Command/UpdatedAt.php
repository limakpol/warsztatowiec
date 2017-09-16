<?php
/**
 * Created by PhpStorm.
 * User: limakpol
 * Date: 9/16/17
 * Time: 6:48 PM
 */

namespace AppBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class UpdatedAt extends Command
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * UpdatedAt constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct();
    }

    /**
     *
     */
    protected function configure()
    {
        $this
            ->setName('app:updated-at')
            ->setDescription('Change updated_at in all tables to timestamp')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $dir = __DIR__.'/../Resources/config/doctrine';

        $schemaFileNames = scandir($dir);

        $schemas =  $this->getSchemas($schemaFileNames, $dir);

        foreach($schemas as $schema)
        {
            $this->changeUpdatedAt($schema, $output);
        }
    }

    /**
     * @param $schemaFileNames
     * @param $dir
     * @return array
     */
    private function getSchemas($schemaFileNames, $dir)
    {
        $schemas = [];

        foreach($schemaFileNames as $schemaFileName)
        {
            if($schemaFileName == '..' || $schemaFileName == '.')
            {
                continue;
            }

            $yamlParser = $this->container->get('app.helper.yaml_parser');

            $schema = $yamlParser->parse($dir, $schemaFileName);

            $schemas[] = $schema;
        }

        return $schemas;
    }

    /**
     * @param $schema
     * @param $output
     * @throws \Doctrine\DBAL\DBALException
     */
    private function changeUpdatedAt($schema, $output)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $connection = $em->getConnection();

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

    /**
     * @param $tableName
     * @param $output
     */
    private function message($tableName, $output)
    {
        $msg = 'Changed updated_at to timestamp in table ' . $tableName;

        $output->writeln($msg);
    }
}