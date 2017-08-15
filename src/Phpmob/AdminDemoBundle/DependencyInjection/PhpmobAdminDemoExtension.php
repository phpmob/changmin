<?php

namespace Phpmob\AdminDemoBundle\DependencyInjection;

use Phpmob\AdminDemoBundle\PhpmobAdminDemoBundle;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class PhpmobAdminDemoExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $this->registerResources(PhpmobAdminDemoBundle::APPLICATION_NAME, $config['driver'], [], $container);

        $loader->load('services.yml');
    }
}
