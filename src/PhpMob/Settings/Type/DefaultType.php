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
class DefaultType implements TypeInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getName()
    {
        return 'default';
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function getter($value)
    {
        return $value;
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function setter($value)
    {
        return $value;
    }
}
