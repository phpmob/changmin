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
interface ImageAwareInterface
{
    /**
     * @return string|null
     */
    public function getFileBasePath();

    /**
     * @return ImageInterface|null
     */
    public function getImage();

    /**
     * @param ImageInterface $image
     */
    public function setImage(ImageInterface $image = null);
}