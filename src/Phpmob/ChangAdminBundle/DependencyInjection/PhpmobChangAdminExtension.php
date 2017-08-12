<?php

namespace Phpmob\ChangAdminBundle\DependencyInjection;

use Phpmob\ChangAdminBundle\PhpmobChangAdminBundle;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class PhpmobChangAdminExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        $config = $this->processConfiguration($this->getConfiguration($config, $container), $config);
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $this->registerResources(PhpmobChangAdminBundle::APPLICATION_NAME, $config['driver'], [], $container);

        $loader->load('services.xml');
    }
}
