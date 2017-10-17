<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\ChangMinBundle\Form\Type;

use PhpMob\MediaBundle\Form\Type\ImageType;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class AdminUserPictureType extends ImageType
{
    /**
     * {@inheritdoc}
     */
    public function getFilterSection()
    {
        return 'admin_user_picture';
    }
}
