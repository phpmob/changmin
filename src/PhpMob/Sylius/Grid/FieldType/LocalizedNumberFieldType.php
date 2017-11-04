<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\Sylius\Grid\FieldType;

use Sylius\Component\Grid\DataExtractor\DataExtractorInterface;
use Sylius\Component\Grid\Definition\Field;
use Sylius\Component\Grid\FieldTypes\FieldTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class LocalizedNumberFieldType implements FieldTypeInterface
{
    /**
     * @var DataExtractorInterface
     */
    private $dataExtractor;

    /**
     * @param DataExtractorInterface $dataExtractor
     */
    public function __construct(DataExtractorInterface $dataExtractor)
    {
        $this->dataExtractor = $dataExtractor;
    }

    /**
     * {@inheritdoc}
     */
    public function render(Field $field, $data, array $options)
    {
        if ('.' !== $field->getPath()) {
            $data = $this->dataExtractor->get($field, $data);
        }

        $field->setOptions($options);

        if ($options['divide'] && $options['multiply']) {
            throw new \LogicException("Can't set `divide` and `multiply` in same time.");
        }

        if (null !== $options['divide']) {
            $data = $data / $options['divide'];
        }

        if (null !== $options['multiply']) {
            $data = $data * $options['multiply'];
        }

        $formatter = twig_get_number_formatter($options['locale'], $options['style']);

        if ($options['precision']) {
            $formatter->setAttribute($formatter::FRACTION_DIGITS, $options['precision']);
        }

        if ('currency' === $options['style']) {
            return $formatter->formatCurrency($data, $options['currency']);
        }

        $typeValues = array(
            'default' => $formatter::TYPE_DEFAULT,
            'int32' => $formatter::TYPE_INT32,
            'int64' => $formatter::TYPE_INT64,
            'double' => $formatter::TYPE_DOUBLE,
            'currency' => $formatter::TYPE_CURRENCY,
        );

        if (!isset($typeValues[$options['type']])) {
            throw new Twig_Error_Syntax(sprintf('The type "%s" does not exist. Known types are: "%s"', $options['type'], implode('", "', array_keys($typeValues))));
        }

        return $formatter->format($data, $typeValues[$options['type']]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'width' => '150px',
                'align' => 'right',
                'style' => 'decimal',
                'type' => 'default',
                'precision' => null,
                'currency' => null,
                'multiply' => null,
                'divide' => null,
                'locale' => null,
            ]
        );

        $resolver->setAllowedTypes('align', 'string');
        $resolver->setAllowedTypes('width', 'string');
        $resolver->setAllowedTypes('style', 'string');
        $resolver->setAllowedTypes('type', 'string');
        $resolver->setAllowedTypes('currency', ['null', 'string']);
        $resolver->setAllowedTypes('precision', ['null', 'int']);
        $resolver->setAllowedTypes('multiply', ['null', 'int']);
        $resolver->setAllowedTypes('divide', ['null', 'int']);
        $resolver->setAllowedTypes('locale', ['string', 'null']);
    }
}
