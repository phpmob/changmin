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
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class ReservedWordValidator extends ConstraintValidator
{
    /**
     * @var array
     */
    private $reservedWords = [];

    /**
     * @param array $words
     */
    public function __construct(array $words = [])
    {
        $this->reservedWords = array_map('strtolower', $words);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty(trim($value))) {
            return;
        }

        if (in_array(mb_strtolower(trim($value)), $this->reservedWords)) {
            $this->context->addViolation($constraint->message, [
                '%value%' => $value,
            ]);
        }
    }
}
