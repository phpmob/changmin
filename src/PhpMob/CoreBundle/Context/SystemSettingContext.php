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

namespace PhpMob\CoreBundle\Context;

use PhpMob\Settings\Manager\SettingManagerInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class SystemSettingContext
{
    /**
     * @var SettingManagerInterface
     */
    private $settingManager;

    /**
     * @param SettingManagerInterface $settingManager
     */
    public function __construct(SettingManagerInterface $settingManager)
    {
        $this->settingManager = $settingManager;
    }

    /**
     * @param string $path eg. section.key
     *
     * @return mixed
     */
    public function get($path)
    {
        return $this->settingManager->get($path, null);
    }
}
