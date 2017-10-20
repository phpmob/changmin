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

use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;

trait LocaleAwareFactoryTrait
{
    /**
     * @var RepositoryInterface
     */
    private $localeRepository;

    /**
     * @var string
     */
    protected $defaultLocale = 'th';

    /**
     * @param RepositoryInterface $localeRepository
     */
    public function setLocaleRepository(RepositoryInterface$localeRepository)
    {
        $this->localeRepository = $localeRepository;
    }

    /**
     * @param string $defaultLocale
     */
    public function setDefaultLocale($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    /**
     * @return array
     */
    protected function getLocales()
    {
        /** @var LocaleInterface[] $locales */
        $locales = $this->localeRepository->findAll();

        foreach ($locales as $locale) {
            yield $locale->getCode();
        }
    }

    /**
     * @param TranslatableInterface $object
     * @param array $properties
     * @param array $data
     */
    protected function setLocalizedData(TranslatableInterface $object, array $properties, array $data)
    {
        $accessor = PropertyAccess::createPropertyAccessor();

        foreach ($this->getLocales() as $localeCode) {
            $object->setCurrentLocale($localeCode);
            $object->setFallbackLocale($localeCode);

            foreach ($properties as $property) {
                $value = $data[$property];
                $value = is_string($value)
                    ? $value
                    : (isset($value[$localeCode])
                        ? $value[$localeCode]
                        : $value[$this->defaultLocale])
                ;

                $accessor->setValue($object, $property, $value);
            }
        }
    }
}
