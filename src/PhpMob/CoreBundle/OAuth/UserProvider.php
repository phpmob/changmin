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

use Doctrine\Common\Persistence\ObjectManager;
use HWI\Bundle\OAuthBundle\Connect\AccountConnectorInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use PhpMob\CoreBundle\Model\WebUserInterface;
use Sylius\Bundle\UserBundle\Provider\UsernameOrEmailProvider;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\User\Canonicalizer\CanonicalizerInterface;
use Sylius\Component\User\Model\UserOAuthInterface;
use Sylius\Component\User\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class UserProvider extends UsernameOrEmailProvider implements AccountConnectorInterface, OAuthAwareUserProviderInterface
{
    /**
     * @var FactoryInterface
     */
    private $oauthFactory;

    /**
     * @var RepositoryInterface
     */
    private $oauthRepository;

    /**
     * @var FactoryInterface
     */
    private $userFactory;

    /**
     * @var ObjectManager
     */
    private $userManager;

    public function __construct(
        string $supportedUserClass,
        FactoryInterface $userFactory,
        UserRepositoryInterface $userRepository,
        FactoryInterface $oauthFactory,
        RepositoryInterface $oauthRepository,
        ObjectManager $userManager,
        CanonicalizerInterface $canonicalizer
    ) {
        parent::__construct($supportedUserClass, $userRepository, $canonicalizer);

        $this->oauthFactory = $oauthFactory;
        $this->oauthRepository = $oauthRepository;
        $this->userFactory = $userFactory;
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response): UserInterface
    {
        $oauth = $this->oauthRepository->findOneBy([
            'provider' => $response->getResourceOwner()->getName(),
            'identifier' => $response->getUsername(),
        ]);

        if ($oauth instanceof UserOAuthInterface) {
            return $oauth->getUser();
        }

        try {
            if (null !== $response->getEmail()) {
                $user = $this->userRepository->findOneByEmail($response->getEmail());

                if (null !== $user) {
                    return $this->updateUserByOAuthUserResponse($user, $response);
                }
            }

            return $this->createUserByOAuthUserResponse($response);
        } catch (AuthenticationException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new AuthorizationException();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response): void
    {
        $this->updateUserByOAuthUserResponse($user, $response);
    }

    /**
     * Ad-hoc creation of user.
     *
     * @param UserResponseInterface $response
     *
     * @return WebUserInterface|UserInterface
     */
    private function createUserByOAuthUserResponse(UserResponseInterface $response): WebUserInterface
    {
        /** @var WebUserInterface $user */
        $user = $this->userFactory->createNew();

        if (!$canonicalEmail = $this->canonicalizer->canonicalize($response->getEmail())) {
            throw new AuthorizationException('phpmob.ui.oauth_response_not_found_email');
        }

        $user->setEmailCanonical($canonicalEmail);

        if ($firstName = $response->getFirstName()) {
            $user->setFirstName($firstName);
        }

        if ($lastName = $response->getLastName()) {
            $user->setLastName($lastName);
        }

        if ($displayName = $response->getRealName()) {
            $user->setDisplayName($displayName);
        }

        // set random password to prevent issue with not nullable field & potential security hole
        $user->setPlainPassword(substr(sha1($response->getAccessToken()), 0, 10));
        $user->setEnabled(true);

        return $this->updateUserByOAuthUserResponse($user, $response);
    }

    /**
     * Attach OAuth sign-in provider account to existing user.
     *
     * @param UserInterface $user
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     */
    private function updateUserByOAuthUserResponse(UserInterface $user, UserResponseInterface $response): UserInterface
    {
        /** @var UserOAuthInterface $oauth */
        $oauth = $this->oauthFactory->createNew();
        $oauth->setIdentifier((string)$response->getUsername());
        $oauth->setProvider($response->getResourceOwner()->getName());
        $oauth->setAccessToken($response->getAccessToken());
        $oauth->setRefreshToken($response->getRefreshToken());

        /** @var WebUserInterface $user */
        $user->addOAuthAccount($oauth);
        $this->userManager->persist($user);
        $this->userManager->flush();

        return $user;
    }
}
