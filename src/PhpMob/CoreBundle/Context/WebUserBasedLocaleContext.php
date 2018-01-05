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

namespace PhpMob\CoreBundle\Context;

use PhpMob\CoreBundle\Model\WebUserInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Context\LocaleNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class WebUserBasedLocaleContext implements LocaleContextInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocaleCode(): string
    {
        $token = $this->tokenStorage->getToken();

        if (null === $token) {
            throw new LocaleNotFoundException();
        }

        $user = $token->getUser();

        if (!$user instanceof WebUserInterface) {
            throw new LocaleNotFoundException();
        }

        if (null === $user->getLocale()) {
            throw new LocaleNotFoundException();
        }

        return $user->getLocale()->getCode();
    }
}
