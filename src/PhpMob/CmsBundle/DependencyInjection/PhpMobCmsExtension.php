<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class PhpMobCmsExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'phpmob_cms';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = $this->processConfiguration(new Configuration(), $configs);
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $this->registerResources('phpmob', $config['driver'], [], $container);

        $container->setParameter('phpmob.locale_database_domains', $config['translation']['domains']);

        $loader->load('services.yml');
    }
}
