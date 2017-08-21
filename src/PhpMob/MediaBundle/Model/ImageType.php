<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\MediaBundle\Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class ImageType
{
    /**
     * @var string
     */
    private $section;

    /**
     * @var string
     */
    private $code;

    /**
     * @var string
     */
    private $label;

    /**
     * @var null
     */
    private $filter = null;

    public function __construct($section = null, $code = null, $label = null, $filter = null)
    {
        $this->section = $section;
        $this->code = $code;
        $this->label = $label;
        $this->filter = $filter;
    }

    /**
     * @return string
     */
    public function getSection()
    {
        return $this->section;
    }

    /**
     * @param string $section
     */
    public function setSection($section)
    {
        $this->section = $section;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return null
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * @param null $filter
     */
    public function setFilter($filter = null)
    {
        $this->filter = $filter;
    }

    /**
     * {@inheritdoc}
     */
    public function transform()
    {
        return sprintf('%s:%s', $this->section, $this->code);
    }

    /**
     * {@inheritdoc}
     */
    public static function reverse($transformed)
    {
        return explode(':', $transformed);
    }
}
