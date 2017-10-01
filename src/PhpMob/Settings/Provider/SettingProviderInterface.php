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

use Doctrine\Common\Collections\Collection;
use PhpMob\Settings\Model\SettingInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface SettingProviderInterface
{
    /**
     * @param string $owner
     *
     * @return Collection|SettingInterface[]
     */
    public function findUserSettings(string $owner);

    /**
     * @return Collection|SettingInterface[]
     */
    public function findGlobalSettings();
}
