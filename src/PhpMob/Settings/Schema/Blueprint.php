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

namespace PhpMob\Settings\Schema;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Blueprint implements \JsonSerializable
{
    /**
     * @var array
     */
    private $data = [];

    public function __construct(array $schema)
    {
        foreach ($schema as $key => $value) {
            $this->data[$key] = $value;
        }
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->data['type'];
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->data['options'];
    }

    /**
     * @return array
     */
    public function getConstraints()
    {
        return $this->data['constraints'];
    }

    /**
     * {@inheritdoc}
     */
    function jsonSerialize()
    {
        return $this->data;
    }
}
