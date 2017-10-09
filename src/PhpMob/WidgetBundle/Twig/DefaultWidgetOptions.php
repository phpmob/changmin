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

namespace PhpMob\WidgetBundle\Twig;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class DefaultWidgetOptions
{
    public static function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'script_path' => null,
                'style_path' => null,
                'image_path' => null,
                'visibility' => 'away',
                'visibility_offset' => '100%',
                'auto_refresh' => false,
                'auto_refresh_timer' => 10000, // 10 secs
                'render_url' => null,
                'render_method' => 'GET',
                'attr_style' => null,
                'attr_class' => null,
                'scroll_position' => 'current',

                /**
                 * widget ajax load callback
                 *
                 * { success: 'global_script_name', error: 'global_script_name' }
                 */
                'callback' => [],

                /**
                 * content loading mode
                 *
                 * pull | more | prev | next | clear | null
                 */
                'mode' => 'clear',

                /**
                 * mask loading style mode
                 *
                 * none | clear | over | ticker | fullscreen | .selector
                 */
                'mask_mode' => 'over',
                'mask_style' => 'wg-loading',
            ]
        );

        $resolver->setRequired('name');
        $resolver->setRequired('template');

        $resolver->setAllowedTypes('template', ['string']);

        $resolver->setAllowedTypes('callback', ['array']);

        $resolver->setAllowedTypes('script_path', ['null', 'string']);
        $resolver->setAllowedTypes('style_path', ['null', 'string']);
        $resolver->setAllowedTypes('image_path', ['null', 'string']);

        $resolver->setAllowedTypes('mode', ['string', 'null']);
        $resolver->setAllowedValues('mode', ['pull', 'more', 'prev', 'next', 'clear', null]);

        $resolver->setAllowedTypes('mask_mode', ['string']);
        $resolver->setAllowedTypes('mask_style', ['string']);

        $resolver->setAllowedTypes('name', ['string']);
        $resolver->setAllowedValues('name', function ($value) {
            return !empty($value);
        });

        $resolver->setAllowedTypes('scroll_position', ['string']);
        $resolver->setAllowedValues('scroll_position', ['top', 'current']);

        $resolver->setAllowedTypes('render_url', ['string', 'null']);
        $resolver->setAllowedTypes('render_method', ['string']);
        $resolver->setAllowedValues('render_method', ['GET', 'POST', 'PUT']);

        $resolver->setAllowedTypes('visibility', ['string']);
        $resolver->setAllowedValues('visibility', ['away', 'onscreen']);

        $resolver->setAllowedTypes('visibility_offset', ['string']);

        $resolver->setAllowedTypes('auto_refresh', ['string', 'boolean']);
        $resolver->setAllowedValues('auto_refresh', [true, false, 'onscreen']);

        $resolver->setAllowedTypes('auto_refresh_timer', ['integer']);
        $resolver->setNormalizer('auto_refresh_timer', function (Options $options, $value) {
            if ($value < 10000) {
                $value = 10000;
            }

            return $value;
        });
    }
}
