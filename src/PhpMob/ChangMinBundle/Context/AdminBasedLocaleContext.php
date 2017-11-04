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

namespace PhpMob\ChangMinBundle\Context;

use PhpMob\ChangMinBundle\Model\AdminUserInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Locale\Context\LocaleNotFoundException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class AdminBasedLocaleContext implements LocaleContextInterface
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

        if (!$user instanceof AdminUserInterface) {
            throw new LocaleNotFoundException();
        }

        if (!$user->getLocaleCode()) {
            throw new LocaleNotFoundException();
        }

        return $user->getLocaleCode();
    }
}
