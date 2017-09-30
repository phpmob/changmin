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

use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordRequirementsValidator;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraint;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class PasswordRequirementValidator extends PasswordRequirementsValidator
{
    /**
     * @var array
     */
    private $options = [];

    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->configureOptions($resolver);
        $this->options = $resolver->resolve($options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    private function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'min_length' => null,
            'letters' => null,
            'case_diff' => null,
            'numbers' => null,
            'special_character' => null,
        ]);

        $resolver->setAllowedTypes('min_length', ['null', 'int']);
        $resolver->setAllowedTypes('letters', ['null', 'bool']);
        $resolver->setAllowedTypes('case_diff', ['null', 'bool']);
        $resolver->setAllowedTypes('numbers', ['null', 'bool']);
        $resolver->setAllowedTypes('special_character', ['null', 'bool']);
    }

    /**
     * @param $name
     * @param $property
     * @param Constraint $constraint
     */
    private function setConfigureOption($name, $property, Constraint $constraint)
    {
        if (null !== $this->options[$name]) {
            $constraint->$property = $this->options[$name];
        }
    }

    /**
     * @param null|string $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $this->setConfigureOption('min_length', 'minLength', $constraint);
        $this->setConfigureOption('letters', 'requireLetters', $constraint);
        $this->setConfigureOption('case_diff', 'requireCaseDiff', $constraint);
        $this->setConfigureOption('numbers', 'requireNumbers', $constraint);
        $this->setConfigureOption('special_character', 'requireSpecialCharacter', $constraint);

        parent::validate($value, $constraint);
    }
}
