<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\ChangMinBundle\Form\Type;

use Sylius\Bundle\UserBundle\Form\Type\UserType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class AdminUserType extends UserType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('picture', AdminUserPictureType::class, [])
        ;
    }
}
