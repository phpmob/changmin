<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cool\DemoBundle\Model;

use PhpMob\MediaBundle\Model\ImageAwareInterface;
use Sylius\Component\User\Model\UserInterface as BaseUserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface DemoUserInterface extends BaseUserInterface, ImageAwareInterface
{
}
