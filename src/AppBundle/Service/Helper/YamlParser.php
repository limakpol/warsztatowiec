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
}