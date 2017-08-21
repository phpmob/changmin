<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle;

use PhpMob\CmsBundle\DependencyInjection\PhpMobCmsExtension;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class PhpMobCmsBundle extends AbstractResourceBundle
{
    /**
     * @var string
     */
    protected $mappingFormat = self::MAPPING_YAML;

    public function __construct()
    {
        $this->extension = new PhpMobCmsExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
            SyliusResourceBundle::DRIVER_DOCTRINE_MONGODB_ODM,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace()
    {
        return 'PhpMob\CmsBundle\Model';
    }

    /**
     * {@inheritdoc}
     */
    protected function getBundlePrefix()
    {
        return $this->extension->getAlias();
    }
}
