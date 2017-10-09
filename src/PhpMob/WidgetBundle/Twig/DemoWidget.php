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
class DemoWidget extends AbstractWidgetExtension
{
    /**
     * {@inheritdoc}
     */
    public static function getName()
    {
        return 'wg_demo';
    }

    /**
     * {@inheritdoc}
     */
    protected function getData(array $options = [])
    {
        return ['foo' => 'bar'];
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'template' => '@PhpMobWidget/demoWidget.html.twig',
        ]);
    }
}
