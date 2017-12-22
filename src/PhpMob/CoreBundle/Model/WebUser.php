<?php

namespace PhpMob\CoreBundle\Model;

use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\User\Model\User as BaseUser;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class WebUser extends BaseUser implements WebUserInterface
{
    /**
     * @var WebUserPictureInterface
     */
    protected $picture;

    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var string
     */
    protected $statusMessage;

    /**
     * @var string
     */
    protected $firstName;

    /**
     * @var string
     */
    protected $lastName;

    /**
     * @var string
     */
    protected $gender;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var \DateTime
     */
    protected $birthday;

    /**
     * @var string
     */
    protected $countryCode;

    /**
     * @var LocaleInterface
     */
    protected $locale;

    /**
     * {@inheritdoc}
     */
    public function getFileBasePath()
    {
        return '/private/users';
    }

    /**
     * {@inheritdoc}
     */
    public function getPicture(): ?WebUserPictureInterface
    {
        return $this->picture;
    }

    /**
     * {@inheritdoc}
     */
    public function setPicture(?WebUserPictureInterface $picture = null): void
    {
        $this->picture = $picture ? ($picture->getFile() ? $picture : null) : null;

        if ($this->picture) {
            $picture->setOwner($this);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayName(): string
    {
        return (string) ($this->displayName ?? ($this->getFullName() ?? $this->email));
    }

    /**
     * {@inheritdoc}
     */
    public function setDisplayName(?string $displayName = null): void
    {
        $this->displayName = (string)$displayName;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusMessage(): string
    {
        return (string) $this->statusMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function setStatusMessage(?string $statusMessage = null)
    {
        $this->statusMessage = (string)$statusMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function getFirstName(): string
    {
        return (string)$this->firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function setFirstName(?string $firstName = null): void
    {
        $this->firstName = (string)$firstName;
    }

    /**
     * {@inheritdoc}
     */
    public function getLastName(): string
    {
        return (string)$this->lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function setLastName(?string $lastName = null): void
    {
        $this->lastName = (string)$lastName;
    }

    /**
     * {@inheritdoc}
     */
    public function getFullName(): string
    {
        return trim(sprintf('%s %s', $this->getFirstName(), $this->getLastName()));
    }

    /**
     * {@inheritdoc}
     */
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * {@inheritdoc}
     */
    public function setGender(?string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoneNumber(): string
    {
        return (string)$this->phoneNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function setPhoneNumber(string $phoneNumber = null): void
    {
        $this->phoneNumber = (string)$phoneNumber;
    }

    /**
     * {@inheritdoc}
     */
    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    /**
     * {@inheritdoc}
     */
    public function setBirthday(?\DateTime $birthday = null): void
    {
        $this->birthday = $birthday;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountryCode(): string
    {
        return (string)$this->countryCode;
    }

    /**
     * {@inheritdoc}
     */
    public function setCountryCode(?string $countryCode = null): void
    {
        $this->countryCode = (string)$countryCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getLocale(): ?LocaleInterface
    {
        return $this->locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setLocale(?LocaleInterface $locale = null): void
    {
        $this->locale = $locale;
    }

    /**
     * {@inheritdoc}
     */
    public function setEmailCanonical(?string $emailCanonical): void
    {
        parent::setEmailCanonical($emailCanonical);

        if (!$this->email) {
            $this->email = $emailCanonical;
        }

        if (!$this->usernameCanonical) {
            $this->setUsernameCanonical($emailCanonical);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setUsernameCanonical(?string $usernameCanonical): void
    {
        parent::setUsernameCanonical($usernameCanonical);

        if (!$this->username) {
            $this->username = $usernameCanonical;
        }
    }
}
