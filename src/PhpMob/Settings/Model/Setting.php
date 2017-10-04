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

namespace PhpMob\Settings\Model;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class Setting implements SettingInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    private $section;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $owner;

    /**
     * @var \DateTimeInterface|null
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface|null
     */
    protected $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getSection(): string
    {
        return $this->section;
    }

    /**
     * {@inheritdoc}
     */
    public function setSection(string $section): void
    {
        $this->section = $section;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     */
    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function getValue(): string
    {
        return (string)$this->value;
    }

    /**
     * {@inheritdoc}
     */
    public function setValue(?string $value): void
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getOwner(): ?string
    {
        return $this->owner;
    }

    /**
     * {@inheritdoc}
     */
    public function setOwner(?string $owner): void
    {
        $this->owner = $owner;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface|null $createdAt
     */
    public function setCreatedAt(?\DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeInterface|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeInterface $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function isEqual(SettingInterface $setting)
    {
        return $this->isEquals($setting->getSection(), $setting->getKey(), $setting->getOwner());
    }

    /**
     * {@inheritdoc}
     */
    public function isEquals(string $section, string $key, ?string $owner = null)
    {
        return $section === $this->getSection()
            && $key === $this->getKey()
            && $owner === $this->getOwner();
    }
}
