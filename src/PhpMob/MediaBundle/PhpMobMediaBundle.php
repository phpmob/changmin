<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\MediaBundle;

use PhpMob\MediaBundle\DependencyInjection\Compiler;
use PhpMob\MediaBundle\DependencyInjection\PhpMobMediaExtension;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

// TODO: https://github.com/helios-ag/FMElfinderBundle/issues/294
define('ELFINDER_IMG_PARENT_URL', '/assets/elfinder/dist');

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class PhpMobMediaBundle extends AbstractResourceBundle
{
    public function __construct()
    {
        $this->extension = new PhpMobMediaExtension();
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new Compiler\RegisterImageTypesPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers(): array
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
            SyliusResourceBundle::DRIVER_DOCTRINE_MONGODB_ODM,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace(): ?string
    {
        return 'PhpMob\MediaBundle\Model';
    }

    /**
     * {@inheritdoc}
     */
    protected function getBundlePrefix(): string
    {
        return $this->extension->getAlias();
    }
}
