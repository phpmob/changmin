<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpmob\FileBundle;

use Phpmob\FileBundle\DependencyInjection\Compiler;
use Phpmob\FileBundle\DependencyInjection\FileExtension;
use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class FileBundle extends AbstractResourceBundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new Compiler\RegisterImageTypesPass());
    }

    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        return new FileExtension();
    }

    /**
     * {@inheritdoc}
     */
    protected function getBundlePrefix()
    {
        return $this->getContainerExtension()->getAlias();
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
        return 'Phpmob\FileBundle\Model';
    }
}
