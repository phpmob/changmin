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

namespace PhpMob\ChangMinBundle\Fixture;

use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Translation\Provider\TranslationLocaleProviderInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

trait LocaleAwareFactoryTrait
{
    /**
     * @var TranslationLocaleProviderInterface
     */
    private $translationProvider;

    /**
     * @param TranslationLocaleProviderInterface $translationProvider
     */
    public function setTranslationProvider(TranslationLocaleProviderInterface $translationProvider)
    {
        $this->translationProvider = $translationProvider;
    }

    /**
     * @param TranslatableInterface $object
     * @param array $properties
     * @param array $data
     */
    protected function setLocalizedData(TranslatableInterface $object, array $properties, array $data)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ($this->translationProvider->getDefinedLocalesCodes() as $localeCode) {
            $object->setCurrentLocale($localeCode);
            $object->setFallbackLocale($localeCode);

            foreach ($properties as $property) {
                $value = $data[$property];
                $value = is_string($value)
                    ? $value
                    : $value[$localeCode]
                ;

                $accessor->setValue($object, $property, $value);
            }
        }
    }
}
