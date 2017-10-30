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

        return twig_localized_number_filter(
            $data,
            $options['style'],
            $options['type'],
            $options['locale']
        );
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
