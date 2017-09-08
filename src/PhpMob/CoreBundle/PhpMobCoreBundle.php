<?php

namespace PhpMob\CoreBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use PhpMob\CoreBundle\DependencyInjection\PhpMobCoreExtension;

class PhpMobCoreBundle extends AbstractResourceBundle
{
    public function __construct()
    {
        $this->extension = new PhpMobCoreExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace(): ?string
    {
        return 'PhpMob\CoreBundle\Model';
    }

    /**
     * {@inheritdoc}
     */
    protected function getBundlePrefix(): string
    {
        return $this->extension->getAlias();
    }
}
