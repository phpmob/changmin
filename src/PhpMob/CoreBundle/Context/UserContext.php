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

use PhpMob\CoreBundle\Model\WebUser;
use PhpMob\CoreBundle\Model\WebUserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @mixin WebUser
 */
class UserContext
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
     * @return WebUserInterface|null
     */
    public function getUser()
    {
        return $this->tokenStorage->getToken()->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function __call($path, $args)
    {
        if (!$user = $this->getUser()) {
            return null;
        }

        switch (true) {
            case method_exists($user, $method = 'get'.ucfirst($path)):
                break;
            case method_exists($user, $method = 'set'.ucfirst($path)):
                break;
            case method_exists($user, $method = 'is'.ucfirst($path)):
                break;
            case method_exists($user, $method = 'has'.ucfirst($path)):
                break;
            default:
                $method = $path;
        }

        return call_user_func_array([$user, $method], [$args]);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return (string) $this->getUser();
    }
}
