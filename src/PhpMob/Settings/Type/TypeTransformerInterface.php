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

namespace PhpMob\Settings\Type;

use PhpMob\Settings\Model\SettingInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface TypeTransformerInterface
{
    /**
     * @param SettingInterface $setting
     */
    public function transform(SettingInterface $setting);

    /**
     * @param SettingInterface $setting
     */
    public function reverse(SettingInterface $setting);
}
