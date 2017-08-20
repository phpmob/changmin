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

namespace Phpmob\MediaBundle\EventListener;

use Phpmob\MediaBundle\Registry\ImageTypeRegistry;


/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DoctrineEventManagerImageTypeRegistryListener
{
    /**
     * @var ImageTypeRegistry
     */
    private $imageTypeRegistry;

    public function __construct(ImageTypeRegistry $imageTypeRegistry)
    {
        $this->imageTypeRegistry = $imageTypeRegistry;
    }

    /**
     * @return ImageTypeRegistry
     */
    public function getImageTypeRegistry()
    {
        return $this->imageTypeRegistry;
    }
}
