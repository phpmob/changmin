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

namespace PhpMob\Settings\Tests;

use PhpMob\Settings\Model\Setting;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class FixtureRemote
{
    const TEST_USER_OWNER = 'demo';

    public static function allSettings()
    {
        return self::onlyGlobalSettings() + self::onlyOwnerSettings();
    }

    public static function createModel($section, $key, $value, $owner = null)
    {
        $setting = new Setting();
        $setting->setOwner($owner);
        $setting->setSection($section);
        $setting->setKey($key);
        $setting->setValue($value);

        return $setting;
    }

    public static function onlyGlobalSettings()
    {
        return [
            self::createModel('section1', 'foo', 'foo_value_remote'),
            self::createModel('section1', 'bar', 'bar_value_remote'),
            self::createModel('section4', 'foo', 'foo_value_remote'),
            self::createModel('section4', 'bar', 'bar_value_remote'),
        ];
    }

    public static function onlyOwnerSettings()
    {
        return [
            self::createModel('section2', 'foo', 'foo_value_remote', FixtureRemote::TEST_USER_OWNER),
            self::createModel('section2', 'bar', 'bar_value_remote', FixtureRemote::TEST_USER_OWNER),
            self::createModel('section3', 'foo', 'foo_value_remote', FixtureRemote::TEST_USER_OWNER),
        ];
    }
}
