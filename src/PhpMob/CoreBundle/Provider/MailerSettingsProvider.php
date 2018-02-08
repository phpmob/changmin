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

namespace PhpMob\CoreBundle\Provider;

use PhpMob\CoreBundle\Context\SystemSettingContext;
use Sylius\Component\Mailer\Provider\DefaultSettingsProviderInterface;

class MailerSettingsProvider implements DefaultSettingsProviderInterface
{
    /**
     * @var DefaultSettingsProviderInterface
     */
    private $decoratedProvider;

    /**
     * @var SystemSettingContext
     */
    private $settings;

    public function __construct(DefaultSettingsProviderInterface $decoratedProvider, SystemSettingContext $settingManager)
    {
        $this->decoratedProvider = $decoratedProvider;
        $this->settings = $settingManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderName(): string
    {
        return $this->settings->get('emails.sender_name') ?? $this->decoratedProvider->getSenderName();
    }

    /**
     * {@inheritdoc}
     */
    public function getSenderAddress(): string
    {
        return $this->settings->get('emails.sender_address') ?? $this->decoratedProvider->getSenderAddress();
    }
}
