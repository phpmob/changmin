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

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DemoLazyLoadWidget extends AbstractWidgetExtension
{
    /**
     * {@inheritdoc}
     */
    public static function getName()
    {
        return 'wg_demo_lazy';
    }

    /**
     * {@inheritdoc}
     */
    protected function getData(array $options = [])
    {
        return ['lazy' => "i'm lazy load."];
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'page' => 0,
            'visibility' => 'onscreen',
            'template' => '@PhpMobWidget/demoLazyLoadWidget.html.twig',
        ]);
    }
}
