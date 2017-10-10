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

namespace PhpMob\CmsBundle\LocaleLoader;

use PhpMob\CmsBundle\Model\LocaleInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DatabaseLoader implements LoaderInterface
{
    /**
     * @var RepositoryInterface
     */
    private $localeRepository;

    public function __construct(RepositoryInterface $repository)
    {
        $this->localeRepository = $repository;
    }

    /**
     * {@inheritdoc}
     */
    public function load($resource, $localeCode, $domain = 'messages')
    {
        $catalogue = new MessageCatalogue($localeCode);

        /** @var LocaleInterface $locale */
        if (!$locale = $this->localeRepository->findOneBy(['code' => $localeCode])) {
            return $catalogue;
        }

        $translations = $locale->getTranslations();

        if (!array_key_exists($domain, $translations)) {
            return $catalogue;
        }

        $translations = $translations[$domain];

        $this->flatten($translations);

        foreach ($translations as $key => $message) {
            $catalogue->set($key, $message, $domain);
        }

        return $catalogue;
    }

    /**
     * Source: \Symfony\Component\Translation\Loader\ArrayLoader::flatten
     * Flattens an nested array of translations.
     *
     * The scheme used is:
     *   'key' => array('key2' => array('key3' => 'value'))
     * Becomes:
     *   'key.key2.key3' => 'value'
     *
     * This function takes an array by reference and will modify it
     *
     * @param array  &$messages The array that will be flattened
     * @param array  $subnode   Current subnode being parsed, used internally for recursive calls
     * @param string $path      Current path being parsed, used internally for recursive calls
     */
    private function flatten(array &$messages, array $subnode = null, $path = null)
    {
        if (null === $subnode) {
            $subnode = &$messages;
        }

        foreach ($subnode as $key => $value) {
            if (is_array($value)) {
                $nodePath = $path ? $path.'.'.$key : $key;
                $this->flatten($messages, $value, $nodePath);
                if (null === $path) {
                    unset($messages[$key]);
                }
            } elseif (null !== $path) {
                $messages[$path.'.'.$key] = $value;
            }
        }
    }
}
