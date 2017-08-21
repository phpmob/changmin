<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\MediaBundle\Doctrine\DBAL\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use PhpMob\MediaBundle\Model\ImageType as ImageTypeChoice;
use PhpMob\MediaBundle\Registry\ImageTypeRegistry;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class ImageType extends Type
{
    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getVarcharTypeDeclarationSQL($fieldDeclaration);
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultLength(AbstractPlatform $platform)
    {
        return $platform->getVarcharDefaultLength();
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (!$value) {
            return null;
        }

        $listeners = $platform->getEventManager()->getListeners('imageTypeRegistry');
        $listener = array_shift($listeners);
        /** @var ImageTypeRegistry $registry */
        $registry = $listener->getImageTypeRegistry();

        list($section, $code) = ImageTypeChoice::reverse($value);

        return $registry->getSectionType($section, $code);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value) {
            return null;
        }

        return $value->transform();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'phpmob_image_type';
    }
}
