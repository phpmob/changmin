<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\DemoBundle\Model;

use PhpMob\MediaBundle\Model\ImageInterface;
use Sylius\Component\User\Model\UserAwareInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface DemoUserPictureInterface extends ImageInterface, UserAwareInterface
{

}
