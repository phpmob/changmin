<?php

namespace PhpMob\DemoBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\ResourceBundleInterface;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

class PhpMobDemoBundle extends AbstractResourceBundle
{
    /**
     * @var string namespace
     */
    const APPLICATION_NAME = 'demo';

    /**
     * @var string
     */
    protected $mappingFormat = ResourceBundleInterface::MAPPING_YAML;

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
}
