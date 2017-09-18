<?php

declare(strict_types=1);

namespace PhpMob\CoreBundle\Model;

use Sylius\Component\Resource\Model\CodeAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface UserGroupInterface extends ResourceInterface, CodeAwareInterface
{
    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void;
}
