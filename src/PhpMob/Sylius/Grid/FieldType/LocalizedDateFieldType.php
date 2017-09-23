<?php

namespace PhpMob\Sylius\Grid\FieldType;

use Sylius\Component\Grid\DataExtractor\DataExtractorInterface;
use Sylius\Component\Grid\Definition\Field;
use Sylius\Component\Grid\FieldTypes\FieldTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocalizedDateFieldType implements FieldTypeInterface
{
    /**
     * @var DataExtractorInterface
     */
    private $dataExtractor;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @param DataExtractorInterface $dataExtractor
     * @param \Twig_Environment $twig
     */
    public function __construct(DataExtractorInterface $dataExtractor, \Twig_Environment $twig)
    {
        $this->dataExtractor = $dataExtractor;
        $this->twig = $twig;
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

        return twig_localized_date_filter(
            $this->twig,
            $data,
            $options['dateFormat'],
            $options['timeFormat'],
            $options['locale'],
            $options['timezone']
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
                'align' => 'left',
                'dateFormat' => 'medium',
                'timeFormat' => 'medium',
                'locale' => null,
                'timezone' => null,
            ]
        );

        $resolver->setAllowedTypes('align', 'string');
        $resolver->setAllowedTypes('width', 'string');
        $resolver->setAllowedTypes('dateFormat', 'string');
        $resolver->setAllowedTypes('timeFormat', 'string');
        $resolver->setAllowedTypes('locale', ['string', 'null']);
        $resolver->setAllowedTypes('timezone', ['string', 'null']);
    }
}
