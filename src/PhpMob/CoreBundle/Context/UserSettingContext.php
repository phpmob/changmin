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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class UserSettingContext
{
    /**
     * @var SettingManagerInterface
     */
    private $settingManager;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param SettingManagerInterface $settingManager
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(SettingManagerInterface $settingManager, TokenStorageInterface $tokenStorage)
    {
        $this->settingManager = $settingManager;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param string $path eg. section.key
     *
     * @return mixed
     */
    public function get($path)
    {
        return $this->settingManager->get($path, $this->tokenStorage->getToken()->getUsername());
    }
}
