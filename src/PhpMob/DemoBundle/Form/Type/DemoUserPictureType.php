<?php

namespace PhpMob\DemoBundle\Form\Type;

use PhpMob\MediaBundle\Form\Type\ImageType;

class DemoUserPictureType extends ImageType
{
    /**
     * {@inheritdoc}
     */
    public function getFilterSection()
    {
        return 'user_picture';
    }
}
