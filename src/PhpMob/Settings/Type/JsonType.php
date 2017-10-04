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

namespace PhpMob\Settings\Type;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class JsonType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getName()
    {
        return 'json';
    }

    /**
     * @param mixed $value
     *
     * @return array
     */
    public function getter($value)
    {
        return json_decode($value, true);
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    public function setter($value)
    {
        return json_encode($value);
    }
}
