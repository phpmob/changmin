<?php

namespace PhpMob\Sylius\ExpressionLanguage;

use Sylius\Bundle\ResourceBundle\ExpressionLanguage\NotNullExpressionFunctionProvider;
use Symfony\Component\DependencyInjection\ExpressionLanguage as BaseExpressionLanguage;
use Symfony\Component\ExpressionLanguage\ParserCache\ParserCacheInterface;

final class ExpressionLanguage extends BaseExpressionLanguage
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ParserCacheInterface $parser = null, array $providers = array())
    {
        array_unshift($providers, new NotNullExpressionFunctionProvider());
        array_unshift($providers, new DefaultNullValueExpressionFunctionProvider());

        parent::__construct($parser, $providers);
    }
}
