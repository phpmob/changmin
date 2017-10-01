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

namespace PhpMob\Setting\Provider;

use Doctrine\Common\Collections\Collection;
use PhpMob\Setting\Model\SettingInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface SettingProviderInterface
{
    /**
     * @param UserInterface $user
     *
     * @return Collection|SettingInterface[]
     */
    public function findUserSettings(UserInterface $user);

    /**
     * @return Collection|SettingInterface[]
     */
    public function findGlobalSettings();
}
