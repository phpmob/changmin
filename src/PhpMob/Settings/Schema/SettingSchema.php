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
 *
 * @property string $section
 * @property string $key
 * @property mixed $defaultValue
 * @property string $type
 * @property Blueprint $blueprint
 */
class SettingSchema
{
    /**
     * @var array
     */
    private $data = [];

    public function __construct(array $schema)
    {
        foreach ($schema as $key => $value) {
            $this->data[$key] = 'blueprint' === $key ? new Blueprint($value) : $value;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __get($key)
    {
        return $this->data[$key];
    }
}
