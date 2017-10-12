<?php

namespace PhpMob\Sylius\Grid\FieldType;

use Sylius\Component\Grid\DataExtractor\DataExtractorInterface;
use Sylius\Component\Grid\Definition\Field;
use Sylius\Component\Grid\FieldTypes\FieldTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NumberFieldType implements FieldTypeInterface
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

        $formatter = twig_get_number_formatter(
            $options['locale'],
            $options['style']
        );

        if ('currency' === $options['style']) {
            return $formatter->formatCurrency($data, $options['type']);
        }

        return $formatter->format($data, $options['type']);
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
                /**
                 * decimal | currency | percent | scientific | spellout | ordinal | duration
                 */
                'style' => 'decimal',
                /**
                 * default | int32 | int64 | double | currency
                 */
                'type' => 'default',
                'locale' => null,
            ]
        );

        $resolver->setAllowedTypes('align', 'string');
        $resolver->setAllowedTypes('width', 'string');
        $resolver->setAllowedTypes('style', 'string');
        $resolver->setAllowedTypes('type', 'string');
        $resolver->setAllowedTypes('locale', ['string', 'null']);
    }
}
