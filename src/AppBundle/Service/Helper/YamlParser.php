<?php

namespace AppBundle\Service\Helper;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Yaml;

class YamlParser
{
    public function parse($fileDir, $fileName)
    {
        $locator = new FileLocator($fileDir);

        $yamlFiles = $locator->locate($fileName, null, false);

        $yamlFile = file_get_contents($yamlFiles[0]);

        return Yaml::parse($yamlFile);
    }

    public function getSchemas()
    {
        $fileDir = __DIR__.'/../../Resources/config/doctrine';

        $schemaFileNames = scandir($fileDir);

        $schemas = [];

        foreach($schemaFileNames as $schemaFileName)
        {
            if($schemaFileName == '..' || $schemaFileName == '.')
            {
                continue;
            }

            $schemas[] = $this->parse($fileDir, $schemaFileName);
        }

        return $schemas;
    }

    public function getTableNames()
    {
        $schemas = $this->getSchemas();

        $tableNames = [];

        foreach($schemas as $schema)
        {
            $tableNamesFromSchema = $this->getTableNamesFromSchema($schema);

            $tableNames = array_merge($tableNames, $tableNamesFromSchema);
        }

        return $tableNames;
    }

    private function getTableNamesFromSchema($schema)
    {
        $tableNames = [];

        foreach ($schema as $index)
        {
            $tableNames[] = $index['table'];

            if(isset($index['manyToMany']))
            {
                foreach($index['manyToMany'] as $manyToMany)
                {
                    if(isset($manyToMany['joinTable']))
                    {
                        $tableNames[] = $manyToMany['joinTable']['name'];
                    }
                }
            }
        }

        return $tableNames;
    }
}