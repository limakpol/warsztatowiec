<?php

use CustomerBundle\CustomerBundle;
use DeliveryBundle\DeliveryBundle;
use Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle;
use EmailBundle\EmailBundle;
use HeaderBundle\HeaderBundle;
use InvoiceBundle\InvoiceBundle;
use OrderBundle\OrderBundle;
use SaleBundle\SaleBundle;
use ServiceBundle\ServiceBundle;
use SmsBundle\SmsBundle;
use StorageBundle\StorageBundle;
use Symfony\Bundle\AsseticBundle\AsseticBundle;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;
use TrashBundle\TrashBundle;
use UserBundle\UserBundle;
use VehicleBundle\VehicleBundle;
use WarehouseBundle\WarehouseBundle;
use WorkflowBundle\WorkflowBundle;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new AppBundle\AppBundle(),
            new DoctrineMigrationsBundle(),
            new AsseticBundle(),
            new CustomerBundle(),
            new SaleBundle(),
            new VehicleBundle(),
            new OrderBundle(),
            new HeaderBundle(),
            new ServiceBundle(),
            new WarehouseBundle(),
            new DeliveryBundle(),
            new InvoiceBundle(),
            new StorageBundle(),
            new SmsBundle(),
            new EmailBundle(),
            new WorkflowBundle(),
            new TrashBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
            }
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
