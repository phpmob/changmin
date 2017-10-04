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
interface TypeInterface
{
    /**
     * @return string
     */
    public static function getName();

    /**
     * @param mixed $value
     *
     * @return mixed Must be serializable
     */
    public function getter($value);

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function setter($value);
}
