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

namespace PhpMob\CoreBundle\OAuth;

use Symfony\Component\Security\Core\Exception\AuthenticationServiceException;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class AuthorizationException extends AuthenticationServiceException
{
    /**
     * {@inheritdoc}
     */
    public function getMessageKey()
    {
        return $this->message ?? parent::getMessageKey();
    }
}
