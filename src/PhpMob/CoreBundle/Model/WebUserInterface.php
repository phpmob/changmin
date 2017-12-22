<?php

namespace PhpMob\CoreBundle\Model;

use PhpMob\MediaBundle\Model\FileAwareInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\User\Model\UserInterface as BaseUserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface WebUserInterface extends BaseUserInterface, FileAwareInterface
{
    /**
     * @return null|WebUserPictureInterface
     */
    public function getPicture(): ?WebUserPictureInterface;

    /**
     * @param null|WebUserPictureInterface $picture
     */
    public function setPicture(?WebUserPictureInterface $picture = null): void;

    /**
     * @return string
     */
    public function getDisplayName(): string;

    /**
     * @param string $displayName
     */
    public function setDisplayName(?string $displayName = null): void;

    /**
     * @return string
     */
    public function getStatusMessage(): string;

    /**
     * @param string|null $statusMessage
     */
    public function setStatusMessage(?string $statusMessage = null);

    /**
     * @return string
     */
    public function getFirstName(): string;

    /**
     * @param string $firstName
     */
    public function setFirstName(?string $firstName = null): void;

    /**
     * @return string
     */
    public function getLastName(): string;

    /**
     * @param string $lastName
     */
    public function setLastName(?string $lastName = null): void;

    /**
     * @return string
     */
    public function getFullName(): string;

    /**
     * @return string
     */
    public function getGender(): ?string;

    /**
     * @param string $gender
     */
    public function setGender(?string $gender): void;

    /**
     * @return string
     */
    public function getPhoneNumber(): string;

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber = null): void;

    /**
     * @return \DateTime
     */
    public function getBirthday(): ?\DateTime;

    /**
     * @param \DateTime $birthday
     */
    public function setBirthday(?\DateTime $birthday = null): void;

    /**
     * @return string
     */
    public function getCountryCode(): string;

    /**
     * @param string $countryCode
     */
    public function setCountryCode(?string $countryCode = null): void;

    /**
     * @return LocaleInterface
     */
    public function getLocale(): ?LocaleInterface;

    /**
     * @param LocaleInterface $locale
     */
    public function setLocale(?LocaleInterface $locale = null): void;
}
