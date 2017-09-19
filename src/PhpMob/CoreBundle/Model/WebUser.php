<?php

namespace PhpMob\CoreBundle\Model;

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
     * {@inheritdoc}
     */
    public function getFileBasePath()
    {
        return null;
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
    public function setPicture(?WebUserPictureInterface $picture): void
    {
        $this->picture = $picture ? ($picture->getFile() ? $picture : null) : null;

        if ($this->picture) {
            $picture->setOwner($this);
        }
    }
}
