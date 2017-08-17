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

use Phpmob\FileBundle\Model\ImageAwareTrait;
use Sylius\Component\User\Model\User as BaseUser;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DemoUser extends BaseUser implements DemoUserInterface
{
    use ImageAwareTrait;

    /**
     * {@inheritdoc}
     */
    public function getFileBasePath()
    {
        return '/profiles';
    }
}
