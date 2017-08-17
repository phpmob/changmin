<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phpmob\FileBundle\Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
abstract class Image extends File implements ImageInterface
{
    /**
     * @var string
     */
    protected $type;

    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * {@inheritdoc}
     */
    public function setType(ImageType $type = null)
    {
        $this->type = $type;
    }
}
