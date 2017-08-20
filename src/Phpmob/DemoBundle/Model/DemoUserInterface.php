<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpmob\DemoBundle\Model;

use Phpmob\MediaBundle\Model\ImageAwareInterface;
use Sylius\Component\User\Model\UserInterface as BaseUserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface DemoUserInterface extends BaseUserInterface, ImageAwareInterface
{
}
