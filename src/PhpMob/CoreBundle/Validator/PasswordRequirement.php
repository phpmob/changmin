<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace PhpMob\CoreBundle\Validator;

use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordRequirements;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class PasswordRequirement extends PasswordRequirements
{
    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'phpmob.password_requirement';
    }
}
