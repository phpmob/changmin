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

namespace PhpMob\Settings\Tests;

use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class FixtureLocal
{
    public static function allSettings()
    {
        return self::onlyGlobalSettings() + self::onlyOwnerSettings();
    }

    public static function onlyGlobalSettings()
    {
        return [
            'section1' => [
                'label' => 'Section 1',
                'owner_aware' => false,
                'enabled' => true,
                'settings' => [
                    'foo' => [
                        'type' => 'string',
                        'label' => 'foo_label',
                        'value' => 'foo_value',
                        'enabled' => true,
                        'blueprint' => [
                            'type' => TextType::class,
                        ],
                    ],
                    'bar' => [
                        'type' => 'string',
                        'label' => 'bar_label',
                        'value' => 'bar_value',
                        'enabled' => true,
                        'blueprint' => [
                            'type' => TextType::class,
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function onlyOwnerSettings()
    {
        return [
            'section2' => [
                'label' => 'Section 1',
                'owner_aware' => true,
                'enabled' => true,
                'settings' => [
                    'foo' => [
                        'type' => 'string',
                        'label' => 'foo_label',
                        'value' => 'foo_value',
                        'enabled' => true,
                        'blueprint' => [
                            'type' => TextType::class,
                        ],
                    ],
                    'bar' => [
                        'type' => 'string',
                        'label' => 'bar_label',
                        'value' => 'bar_value',
                        'enabled' => true,
                        'blueprint' => [
                            'type' => TextType::class,
                        ],
                    ],
                ],
            ],
            'section3' => [
                'label' => 'Section 3',
                'owner_aware' => true,
                'enabled' => true,
                'settings' => [
                    'foo' => [
                        'type' => 'string',
                        'label' => 'foo_label',
                        'value' => 'foo_value',
                        'enabled' => true,
                        'blueprint' => [
                            'type' => TextType::class,
                        ],
                    ],
                    'bar' => [
                        'type' => 'string',
                        'label' => 'bar_label',
                        'value' => 'bar_value',
                        'enabled' => true,
                        'blueprint' => [
                            'type' => TextType::class,
                        ],
                    ],
                ],
            ],
            'section8' => [
                'label' => 'Section 8',
                'owner_aware' => true,
                'enabled' => true,
                'settings' => [
                    'foo' => [
                        'type' => 'string',
                        'label' => 'foo_label',
                        'value' => 'foo_value',
                        'enabled' => true,
                        'blueprint' => [
                            'type' => TextType::class,
                        ],
                    ],
                    'bar' => [
                        'type' => 'string',
                        'label' => 'bar_label',
                        'value' => 'bar_value',
                        'enabled' => true,
                        'blueprint' => [
                            'type' => TextType::class,
                        ],
                    ],
                ],
            ],
        ];
    }
}
