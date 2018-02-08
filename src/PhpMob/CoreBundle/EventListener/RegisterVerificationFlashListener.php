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

use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class RegisterVerificationFlashListener
{
    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    /**
     * @var string
     */
    private $flashKey;

    public function __construct(?FlashBagInterface $flashBag, ?string $flashKey = null)
    {
        $this->flashBag = $flashBag;
        $this->flashKey = $flashKey ?? 'phpmob.ui.register_verification';
    }

    public function addFlashMessage(): void
    {
        $this->flashBag && $this->flashBag->set('info', $this->flashKey);
    }
}
