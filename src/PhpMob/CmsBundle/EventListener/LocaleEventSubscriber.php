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

namespace PhpMob\CmsBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use PhpMob\CmsBundle\Model\LocaleInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Exception\DeleteHandlingException;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class LocaleEventSubscriber implements EventSubscriber
{
    /**
     * @var LocaleContextInterface
     */
    private $localeContext;

    /**
     * @var array
     */
    private $availableDomains;

    public function __construct(LocaleContextInterface $localeContext, array $availableDomains = [])
    {
        $this->localeContext = $localeContext;
        $this->availableDomains = $availableDomains;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
            'prePersist',
            'preUpdate',
        ];
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     *
     * @return bool
     */
    private function isSupported(LifecycleEventArgs $eventArgs)
    {
        return $eventArgs->getObject() instanceof LocaleInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function preUpdate(LifecycleEventArgs $eventArgs)
    {
        $this->createFakeDomain($eventArgs);
    }

    /**
     * {@inheritdoc}
     */
    public function prePersist(LifecycleEventArgs $eventArgs)
    {
        $this->createFakeDomain($eventArgs);
    }

    /**
     * @param LifecycleEventArgs $eventArgs
     */
    public function createFakeDomain(LifecycleEventArgs $eventArgs)
    {
        if (!$this->isSupported($eventArgs)) {
            return;
        }

        /** @var LocaleInterface $object */
        $object = $eventArgs->getObject();
        $domains = array_intersect(array_keys($object->getTranslations()), $this->availableDomains);

        // create fake domain file
        // http://symfony.com/doc/current/reference/dic_tags.html#translation-loader
        foreach ($domains as $domain) {
            $file = sprintf('%s/../Resources/translations/%s.%s.db', dirname(__DIR__), $domain, strtolower($object->getCode()));

            if (!file_exists($file)) {
                file_put_contents($file, '');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        if (!$this->isSupported($eventArgs)) {
            return;
        }

        if (strtolower($this->localeContext->getLocaleCode()) === strtolower($eventArgs->getObject()->getCode())) {
            throw new DeleteHandlingException(
                'Ups, something went wrong during deleting a resource, please try again.',
                'can_not_delete_default_locale'
            );
        }
    }
}
