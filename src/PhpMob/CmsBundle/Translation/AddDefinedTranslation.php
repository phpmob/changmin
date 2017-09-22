<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Translation;

use PhpMob\CmsBundle\Model\DefinedTranslationInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\TranslatorBagInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class AddDefinedTranslation implements AddDefinedTranslationInterface
{
    /**
     * @var LocaleContextInterface
     */
    private $localeContext;

    /**
     * @var TranslatorBagInterface
     */
    private $translator;

    /**
     * @param LocaleContextInterface $localeContext
     * @param TranslatorBagInterface $translator
     */
    public function __construct(LocaleContextInterface $localeContext, TranslatorBagInterface $translator)
    {
        $this->localeContext = $localeContext;
        $this->translator = $translator;
    }

    /**
     * @param string $localeCode
     *
     * @return bool
     */
    private function isValidLocaleCode($localeCode)
    {
        return strtolower($localeCode) === strtolower($this->localeContext->getLocaleCode());
    }

    /**
     * {@inheritdoc}
     */
    public function addTranslations(DefinedTranslationInterface $definedTranslation)
    {
        $translations = $definedTranslation->getDefinedTranslations();

        if (empty($translations)) {
            return;
        }

        foreach ($translations as $localeCode => $messages) {
            if (empty($messages) || !$this->isValidLocaleCode($localeCode)) {
                continue;
            }

            $this->translator->getCatalogue($localeCode)->addCatalogue(
                (new ArrayLoader())->load($messages, $localeCode)
            );
        }
    }
}
