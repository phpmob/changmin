<?php

namespace Phpmob\ChangAdminBundle;

use Sylius\Bundle\ResourceBundle\AbstractResourceBundle;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;

class PhpmobChangAdminBundle extends AbstractResourceBundle
{
    const APPLICATION_NAME = 'change';

    /**
     * {@inheritdoc}
     */
    public function getSupportedDrivers()
    {
        return [
            SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getModelNamespace()
    {
        return 'Phpmob\ChangAdminBundle\Model';
    }
}
