<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\ChangMinBundle;

use PhpMob\ChangMinBundle\DependencyInjection\ChangMinExtension;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class ChangMinBundle extends AbstractResourceBundle
{
    protected $name = 'ChangMin';

    public function __construct()
    {
        $this->extension = new ChangMinExtension();
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
        return 'PhpMob\ChangMinBundle\Model';
    }

    /**
     * {@inheritdoc}
     */
    protected function getBundlePrefix(): string
    {
        return $this->extension->getAlias();
    }
}
