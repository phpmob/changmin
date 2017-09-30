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

use Symfony\Component\Validator\Constraint;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class ReservedWord extends Constraint
{
    /**
     * Validation message for reserved usernames.
     *
     * @var string
     */
    public $message = 'The value "%value%" is reserved.';

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'phpmob.reserved_word_validator';
    }
}
