<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Yaml\Yaml;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class YamlTransformer implements DataTransformerInterface
{
    /**
     * The level where you switch to inline YAML.
     *
     * @var int
     */
    protected $inlineLevel;

    /**
     * @param int $inlineLevel
     */
    public function __construct($inlineLevel = 10)
    {
        $this->inlineLevel = $inlineLevel;
    }

    /**
     * {@inheritdoc}
     */
    public function reverseTransform($value)
    {
        return (array) Yaml::parse(preg_replace('/\t/', '    ', $value));
    }

    /**
     * {@inheritdoc}
     */
    public function transform($value)
    {
        return Yaml::dump($value, $this->inlineLevel);
    }
}
