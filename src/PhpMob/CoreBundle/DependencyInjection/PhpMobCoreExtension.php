<?php

namespace PhpMob\CoreBundle\DependencyInjection;

use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

class PhpMobCoreExtension extends AbstractResourceExtension
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'phpmob_core';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));

        $this->registerResources('phpmob', $config['driver'], [], $container);

        $loader->load('services.xml');

        $container->setParameter('phpmob.security_firewall_context_name', $config['security']['firewall_context_name']);
        $container->setParameter('phpmob.security_reserved_words', $config['security']['username']['reserved_words']);
        $container->setParameter('phpmob.security_password_requirements', $config['security']['password']['requirements']);
        $container->setParameter('phpmob.security_password_strengths', $config['security']['password']['strengths']);

        if ($config['security']['enabled']) {
            $loader->load('services/security.xml');
        }
    }
}
