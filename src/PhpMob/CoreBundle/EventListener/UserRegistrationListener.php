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

use Doctrine\Common\Persistence\ObjectManager;
use PhpMob\CoreBundle\Model\WebUserInterface;
use Sylius\Bundle\UserBundle\Security\UserLoginInterface;
use Sylius\Bundle\UserBundle\UserEvents;
use Sylius\Component\User\Security\Generator\GeneratorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class UserRegistrationListener
{
    /**
     * @var ObjectManager
     */
    private $userManager;

    /**
     * @var GeneratorInterface
     */
    private $tokenGenerator;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var UserLoginInterface
     */
    private $userLogin;

    /**
     * @var string
     */
    private $firewallContextName;

    /**
     * @param ObjectManager $userManager
     * @param GeneratorInterface $tokenGenerator
     * @param EventDispatcherInterface $eventDispatcher
     * @param UserLoginInterface $userLogin
     * @param string $firewallContextName
     */
    public function __construct(
        ObjectManager $userManager,
        GeneratorInterface $tokenGenerator,
        EventDispatcherInterface $eventDispatcher,
        UserLoginInterface $userLogin,
        $firewallContextName
    ) {
        $this->userManager = $userManager;
        $this->tokenGenerator = $tokenGenerator;
        $this->eventDispatcher = $eventDispatcher;
        $this->userLogin = $userLogin;
        $this->firewallContextName = $firewallContextName;
    }

    /**
     * @param GenericEvent $event
     */
    public function handleUserVerification(GenericEvent $event)
    {
        $user = $event->getSubject();

        Assert::isInstanceOf($user, WebUserInterface::class);
        Assert::notNull($user);

        $this->sendVerificationEmail($user);
    }

    /**
     * @param WebUserInterface $user
     */
    private function sendVerificationEmail(WebUserInterface $user)
    {
        $token = $this->tokenGenerator->generate();
        $user->setEmailVerificationToken($token);

        $this->userManager->persist($user);
        $this->userManager->flush();

        $this->eventDispatcher->dispatch(UserEvents::REQUEST_VERIFICATION_TOKEN, new GenericEvent($user));
    }

    /**
     * @param WebUserInterface $user
     */
    private function enableAndLogin(WebUserInterface $user)
    {
        $user->setEnabled(true);

        $this->userLogin->login($user, $this->firewallContextName);
    }
}
