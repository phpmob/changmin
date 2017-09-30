<?php

namespace PhpMob\MediaBundle\Context;

final class DefaultImageContext
{
    /**
     * @var array
     */
    private $contexts = [];

    /**
     * @var string
     */
    private $activeContext;

    public function setActiveContext($context)
    {
        $this->activeContext = $context;
    }
}
