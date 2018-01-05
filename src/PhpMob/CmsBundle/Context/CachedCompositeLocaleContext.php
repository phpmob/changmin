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

namespace PhpMob\CmsBundle\Context;

use Sylius\Component\Locale\Context\LocaleContextInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class CachedCompositeLocaleContext implements LocaleContextInterface
{
    /**
     * @var null|string
     */
    private $cachedLocaleCode = null;

    /**
     * @var LocaleContextInterface
     */
    private $compositeContext;

    /**
     * @param LocaleContextInterface|CompositeLocaleContext $compositeContext
     */
    public function __construct(LocaleContextInterface $compositeContext)
    {
        $this->compositeContext = $compositeContext;
    }

    /**
     * @param LocaleContextInterface $localeContext
     * @param int $priority
     */
    public function addContext(LocaleContextInterface $localeContext, int $priority = 0): void
    {
        $this->compositeContext->addContext($localeContext, $priority);
    }

    /**
     * {@inheritdoc}
     */
    public function getLocaleCode(): string
    {
        if ($this->cachedLocaleCode) {
            return $this->cachedLocaleCode;
        }

        return $this->cachedLocaleCode = $this->compositeContext->getLocaleCode();
    }
}
