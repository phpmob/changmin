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

use Rollerworks\Component\PasswordStrength\Validator\Constraints\PasswordStrengthValidator as BasePasswordStrengthValidator;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraint;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class PasswordStrengthValidator extends BasePasswordStrengthValidator
{
    /**
     * @var array
     */
    private $options = [];

    public function __construct(TranslatorInterface $translator = null, array $options = [])
    {
        parent::__construct($translator);

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
            'level' => null,
            'unicode_equality' => null,
        ]);

        $resolver->setAllowedTypes('min_length', ['null', 'int']);
        $resolver->setAllowedTypes('level', ['null', 'int']);
        $resolver->setAllowedTypes('unicode_equality', ['null', 'bool']);
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
        $this->setConfigureOption('level', 'minStrength', $constraint);
        $this->setConfigureOption('unicode_equality', 'unicodeEquality', $constraint);

        parent::validate($value, $constraint);
    }
}
