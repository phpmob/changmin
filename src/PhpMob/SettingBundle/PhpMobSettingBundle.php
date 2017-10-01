<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\SettingBundle;

use PhpMob\SettingBundle\DependencyInjection\PhpMobSettingExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class PhpMobSettingBundle extends Bundle
{
    public function __construct()
    {
        $this->extension = new PhpMobSettingExtension();
    }

    /**
     * {@inheritdoc}
     */
    protected function getBundlePrefix(): string
    {
        return $this->extension->getAlias();
    }
}
