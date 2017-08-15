<?php

namespace Phpmob\DemoBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\ResourceBundleInterface;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

class PhpmobDemoBundle extends AbstractResourceBundle
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
        return 'Phpmob\DemoBundle\Model';
    }
}
