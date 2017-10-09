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

use PhpMob\WidgetBundle\Asset\WidgetAssetsInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class WidgetAssetsExtension extends \Twig_Extension
{
    /**
     * @var WidgetAssetsInterface
     */
    private $widgetAssets;

    /**
     * @param WidgetAssetsInterface $assets
     */
    public function __construct(WidgetAssetsInterface $assets)
    {
        $this->widgetAssets = $assets;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new \Twig_Function('phpmob_widget_assets', [$this, 'getAssets'], [
                'needs_environment' => false,
                'is_safe' =>['html'],
            ]),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getAssets()
    {
        $content = '';

        if ($style = trim($this->widgetAssets->getStyle())) {
            $content .= sprintf('<style>%s</style>', $style);
        }

        if ($script = trim($this->widgetAssets->getScript())) {
            $content .= sprintf('<script>$(function(){%s});</script>', $script);
        }

        return $content;
    }
}
