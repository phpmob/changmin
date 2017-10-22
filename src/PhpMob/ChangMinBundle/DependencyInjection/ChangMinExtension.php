<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\ChangMinBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class ChangMinExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'changmin';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $this->registerResources('changmin', $config['driver'], [], $container);

        $loader->load('services.xml');

        if ($config['taxonomy']) {
            $loader->load('services/taxons.xml');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $config = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $config);

        if ($config['taxonomy']) {
            $container->prependExtensionConfig('sylius_taxonomy', [
                'resources' => [
                    'taxon' => [
                        'classes' => [
                            'controller' => 'PhpMob\\ChangMinBundle\\Controller\\TaxonController',
                            'repository' => 'PhpMob\\ChangMinBundle\\Doctrine\\ORM\\TaxonRepository',
                            'form' => 'PhpMob\\ChangMinBundle\\Form\\Type\\TaxonType',
                        ]
                    ]
                ]
            ]);
        }
    }
}
