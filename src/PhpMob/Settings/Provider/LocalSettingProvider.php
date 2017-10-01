<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\Settings\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use PhpMob\Settings\Model\Setting;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class LocalSettingProvider implements SettingProviderInterface
{
    /**
     * @var array
     */
    private $settings;

    /**
     * @param array $settings
     */
    public function __construct(array $settings = [])
    {
        $this->settings = $settings;
    }

    /**
     * {@inheritdoc}
     */
    public function findUserSettings(string $owner)
    {
        return new ArrayCollection([]);
    }

    /**
     * {@inheritdoc}
     */
    public function findGlobalSettings()
    {
        return new ArrayCollection(array_map(function ($setting) {
            $object = new Setting();
            $object->setSection($setting['section']);
            $object->setKey($setting['key']);
            $object->setValue($setting['value']);

            return $object;
        }, $this->settings));
    }
}
