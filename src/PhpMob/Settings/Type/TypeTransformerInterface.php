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
interface TypeTransformerInterface
{
    /**
     * @param string $section
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function transform(string $section, string $key, $value);

    /**
     * @param string $section
     * @param string $key
     * @param mixed $value
     *
     * @return mixed
     */
    public function reverse(string $section, string $key, $value);
}
