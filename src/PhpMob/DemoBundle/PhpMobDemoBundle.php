<?php

namespace PhpMob\DemoBundle;

use PhpMob\DemoBundle\DependencyInjection\PhpMobDemoExtension;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\ResourceBundleInterface;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

class PhpMobDemoBundle extends AbstractResourceBundle
{
    /**
     * @var string
     */
    protected $mappingFormat = ResourceBundleInterface::MAPPING_YAML;

    public function __construct()
    {
        $this->extension = new PhpMobDemoExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace()
    {
        return 'PhpMob\DemoBundle\Model';
    }

    /**
     * {@inheritdoc}
     */
    protected function getBundlePrefix()
    {
        return $this->extension->getAlias();
    }
}
