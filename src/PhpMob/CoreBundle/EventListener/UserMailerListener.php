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

namespace PhpMob\CoreBundle\EventListener;

use PhpMob\CoreBundle\Event\Emails;
use PhpMob\CoreBundle\Model\WebUserInterface;
use Sylius\Bundle\UserBundle\EventListener\MailerListener;
use Sylius\Component\Mailer\Sender\SenderInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class UserMailerListener extends MailerListener
{
    /**
     * @param SenderInterface $emailSender
     */
    public function __construct(SenderInterface $emailSender)
    {
        parent::__construct($emailSender);
    }

    /**
     * @param GenericEvent $event
     *
     * @throws UnexpectedTypeException
     */
    public function sendUserRegistrationEmail(GenericEvent $event)
    {
        $user = $event->getSubject();

        Assert::isInstanceOf($user, WebUserInterface::class);

        $this->emailSender->send(Emails::USER_REGISTRATION, [$user->getEmail()], ['user' => $user]);
    }
}
