<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\ChangMinBundle\Twig\Extension;

use SM\Factory\Factory;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class StateMachineExtension extends \Twig_Extension
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var Factory
     */
    private $factory;

    /**
     * @var array
     */
    private $config = array();

    /**
     * @var array
     */
    private $smConfig = array();

    /**
     * @var string
     */
    private $activeGraph = null;

    public function __construct(TranslatorInterface $translator, Factory $factory, array $config = array(), array $smConfig = array())
    {
        $this->translator = $translator;
        $this->factory = $factory;
        $this->config = $config;
        $this->smConfig = $smConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        $options = array('is_safe' => array('html'));

        return array(
            new \Twig_SimpleFunction('sm_graph_set', array($this, 'setActiveGraph'), $options),
            new \Twig_SimpleFunction('sm_graph_get', array($this, 'getActiveGraph'), $options),
            new \Twig_SimpleFunction('sm_graph_states', array($this, 'getGraphStates'), $options),
            new \Twig_SimpleFunction('sm_possibles', array($this, 'getPossibleTransitions'), $options),
            new \Twig_SimpleFunction('sm_transition_label', array($this, 'getTransitionLabel'), $options),
            new \Twig_SimpleFunction('sm_transition_color', array($this, 'getTransitionColor'), $options),
            new \Twig_SimpleFunction('sm_state_label', array($this, 'getStateLabel'), $options),
            new \Twig_SimpleFunction('sm_state_color', array($this, 'getStateColor'), $options),
        );
    }

    private function checkActiveGraph()
    {
        \Webmozart\Assert\Assert::stringNotEmpty($this->activeGraph, "No active graph.");
    }

    private function getConfigValue($path)
    {
        $this->checkActiveGraph();

        $accessor = PropertyAccess::createPropertyAccessorBuilder()
            ->disableExceptionOnInvalidIndex()
            ->getPropertyAccessor()
        ;

        return $accessor->getValue($this->config, $path);
    }

    /**
     * @param string $graph
     */
    public function setActiveGraph($graph)
    {
        $this->activeGraph = $graph;
    }

    public function getActiveGraph()
    {
        return $this->activeGraph;
    }

    public function getNAColor()
    {
        return $this->config['colors']['na'];
    }

    public function getNegativeColor()
    {
        return $this->config['colors']['negative'];
    }

    public function getPositiveColor()
    {
        return $this->config['colors']['positive'];
    }

    public function getLabel($type, $key)
    {
        $this->checkActiveGraph();

        $translationKey = $this->getConfigValue(
            sprintf('[graphs][%s][%s][%s][translation][key]', $this->activeGraph, $type, $key)
        ) ?: $key;

        $translationDomain = $this->getConfigValue(
            sprintf('[graphs][%s][%s][%s][translation][domain]', $this->activeGraph, $type, $key)
        );

        return $this->translator->trans($translationKey, [], $translationDomain);
    }

    public function getTransitionLabel($transition)
    {
        return $this->getLabel('transitions', $transition);
    }

    public function getStateLabel($state)
    {
        return $this->getLabel('states', $state);
    }

    public function getColor($type, $key)
    {
        return $this->getConfigValue(
            sprintf('[graphs][%s][%s][%s][color]', $this->activeGraph, $type, $key)
        ) ?: $this->getNAColor();
    }

    public function getStateColor($state)
    {
        return $this->getColor('states', $state);
    }

    public function getTransitionColor($transition)
    {
        return $this->getColor('transitions', $transition);
    }

    public function getPossibleTransitions($object)
    {
        $transitions = [];
        $sm = $this->factory->get($object, $this->activeGraph);

        foreach ($sm->getPossibleTransitions() as $name) {
            $transitions[$name] = array(
                'name' => $name,
                'graph' => $this->activeGraph,
                'color' => $this->getTransitionColor($name),
                'label' => $this->getTransitionLabel($name),
            );
        }

        return $transitions;
    }

    public function getGraphStates()
    {
        $this->checkActiveGraph();

        $states = $this->smConfig[$this->activeGraph]['states'];
        $return = array();

        foreach ($states as $state) {
            $return[] = array(
                'name' => $state,
                'label' => $this->getStateLabel($state),
                'color' => $this->getStateColor($state),
            );
        }

        return $return;
    }
}
