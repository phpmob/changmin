<?php

namespace Phpmob\DemoBundle\Form\Type;

use Phpmob\FileBundle\Form\Type\ImageType;

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
