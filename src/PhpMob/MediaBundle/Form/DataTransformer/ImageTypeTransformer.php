<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\MediaBundle\Form\DataTransformer;

use PhpMob\MediaBundle\Model\ImageType;
use PhpMob\MediaBundle\Registry\ImageTypeRegistry;
use Symfony\Component\Form\DataTransformerInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class ImageTypeTransformer implements DataTransformerInterface
{
    /**
     * @var ImageTypeRegistry
     */
    private $imageTypeRegistry;

    /**
     * @param ImageTypeRegistry $imageTypeRegistry
     */
    public function __construct(ImageTypeRegistry $imageTypeRegistry)
    {
        $this->imageTypeRegistry = $imageTypeRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        if ($value instanceof ImageType) {
            return $value->transform();
        }

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        if (!$value) {
            return null;
        }

        /** @var ImageType $value */
        list($section, $code) = ImageType::reverse($value);
        return $this->imageTypeRegistry->getSectionType($section, $code);
    }
}
