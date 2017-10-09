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
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Exception\DeleteHandlingException;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DefaultLocaleDeletionSubscriber implements EventSubscriber
{
    /**
     * @var LocaleContextInterface
     */
    private $localeContext;

    public function __construct(LocaleContextInterface $localeContext)
    {
        $this->localeContext = $localeContext;
    }

    /**
     * {@inheritdoc}
     */
    public function getSubscribedEvents()
    {
        return [
            'preRemove',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function preRemove(LifecycleEventArgs $eventArgs)
    {
        $object = $eventArgs->getObject();

        if (!$object instanceof LocaleInterface) {
            return;
        }

        if (strtolower($this->localeContext->getLocaleCode()) === strtolower($object->getCode())) {
            throw new DeleteHandlingException(
                'Ups, something went wrong during deleting a resource, please try again.',
                'can_not_delete_default_locale'
            );
        }
    }
}
