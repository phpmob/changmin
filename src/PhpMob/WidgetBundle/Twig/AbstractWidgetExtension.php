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
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
abstract class AbstractWidgetExtension extends \Twig_Extension implements WidgetInterface
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var WidgetAssetsInterface
     */
    private $widgetAssets;

    /**
     * @param RouterInterface $router
     */
    final public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param WidgetAssetsInterface $widgetAssets
     */
    final public function setWidgetAssets(WidgetAssetsInterface $widgetAssets)
    {
        $this->widgetAssets = $widgetAssets;
    }

    /**
     * @var array
     */
    protected $defaultOptions = [];

    /**
     * {@inheritdoc}
     */
    abstract public static function getName();

    /**
     * @param array $options
     *
     * @return array
     */
    abstract protected function getData(array $options = []);

    /**
     * {@inheritdoc}
     */
    final public function getFunctions()
    {
        return [
            new \Twig_Function($this->getName(), [$this, 'render'], [
                'needs_environment' => true,
                'is_safe' =>['html'],
            ]),
        ];
    }

    /**
     * @param array $options
     *
     * @return array
     */
    private function resolveOptions(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configure($resolver);

        return $resolver->resolve($options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    private function configure(OptionsResolver $resolver)
    {
        DefaultWidgetOptions::configureOptions($resolver);

        $this->configureOptions($resolver);
    }

    /**
     * Additional options
     *
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
    }

    /**
     * Resolve build options
     *
     * @param array $options
     */
    final public function resolverDefaultOptions(array $options = [])
    {
        $options['name'] = static::getName();

        $this->defaultOptions = $this->resolveOptions($options);
    }

    /**
     * Resolve options for render
     *
     * @param array $options
     *
     * @return array
     */
    private function getOptions(array $options = [])
    {
        return $this->resolveOptions(array_replace_recursive($this->defaultOptions, $options));
    }

    /**
     * {@inheritdoc}
     */
    final public function render(\Twig_Environment $env, array $userOptions = [])
    {
        $data = [];
        $options = $this->getOptions($userOptions);

        if ('away' === $options['visibility']) {
            $data = $this->getData($options);
        }

        if (empty($options['render_url'])) {
            $options['render_url'] = $this->router->generate('phpmob_widget_render', []);
        }

        // todo: session check DoS refresh
        if (false === $options['auto_refresh']) {
            unset($options['auto_refresh']);
            unset($options['auto_refresh_timer']);
        }

        if (!empty($options['script_path'])) {
            $this->widgetAssets->addScript($options['script_path']);
        }

        if (!empty($options['style_path'])) {
            $this->widgetAssets->addScript($options['style_path']);
        }

        $this->widgetAssets->increaseCounter();

        return $env->render($options['template'], [
            'data' => $data,
            'options' => $options,
            'userOptions' => $userOptions,
        ]);
    }
}
