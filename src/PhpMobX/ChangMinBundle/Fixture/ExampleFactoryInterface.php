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

namespace PhpMob\ChangMinBundle\Fixture;

/**
 * @author Kamil Kokot <kamil@kokot.me>
 */
interface ExampleFactoryInterface
{
    /**
     * @param array $options
     *
     * @return object
     */
    public function create(array $options = []);
}
