<?php

declare(strict_types=1);

namespace PhpMob\ChangMinBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateTimeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        // html5 native base
        $resolver->setDefaults([
            'html5' => true,
            'format' => DateTimeType::HTML5_FORMAT,
            'date_widget' => 'single_text',
            'time_widget' => 'single_text',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return DateTimeType::class;
    }
}
