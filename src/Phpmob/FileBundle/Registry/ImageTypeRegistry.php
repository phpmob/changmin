<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phpmob\FileBundle\Registry;

use Phpmob\FileBundle\Model\ImageType;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class ImageTypeRegistry
{
    /**
     * @var array
     */
    private $types = [];

    public function __construct(array $types = [])
    {
        foreach ($types as $section => $_types) {
            $sectionTypes = [];

            foreach ($_types as $type) {
                $sectionTypes[] = new ImageType($section, $type['code'], $type['label'], $type['filter']);
            }

            $this->types[$section] = $sectionTypes;
        }
    }

    /**
     * @param $section
     *
     * @return ImageType[]
     */
    public function getSectionTypes($section)
    {
        if (!isset($this->types[$section])) {
            return [];
        }

        return $this->types[$section];
    }

    /**
     * @param $section
     * @param $code
     *
     * @return null|ImageType
     */
    public function getSectionType($section, $code)
    {
        if (!isset($this->types[$section])) {
            return null;
        }

        $types = array_filter(
            $this->types[$section],
            function (ImageType $item) use ($code) {
                return strtolower($code) === strtolower($item->getCode());
            }
        );

        return $types[0];
    }
}
