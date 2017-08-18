<?php

/*
 * This file is part of the Phpmob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phpmob\FileBundle\Form\Type;

use Phpmob\FileBundle\Form\DataTransformer\ImageTypeTransformer;
use Phpmob\FileBundle\Registry\ImageTypeRegistry;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
abstract class ImageType extends AbstractResourceType
{
    /**
     * @var ImageTypeRegistry
     */
    private $imageTypeRegistry;

    /**
     * @param ImageTypeRegistry $imageTypeRegistry
     */
    public function setImageTypeRegistry(ImageTypeRegistry $imageTypeRegistry)
    {
        $this->imageTypeRegistry = $imageTypeRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $types = $this->imageTypeRegistry->getSectionTypes($this->getFilterSection());

        if (!empty($types)) {
            if (count($types) > 1) {
                $builder->add('type', ChoiceType::class, [
                    'required' => false,
                    'label' => 'phpmob.form.image.type',
                    'placeholder' => 'phpmob.form.image.type',
                    'choices' => $types,
                    'choice_value' => 'code',
                    'choice_label' => 'label'
                ]);
            } else {
                $builder
                    ->add('type', HiddenType::class, [
                        'data_class' => null,
                        'data' => $types[0],
                    ])
                    ->get('type')
                    ->addViewTransformer(new ImageTypeTransformer($this->imageTypeRegistry))
                ;
            }
        }

        $builder
            ->add('file', FileType::class, [
                'label' => 'phpmob.form.image.file',
                'required' => false,
            ])
            ->add('shouldRemove', CheckboxType::class, [
                'label' => 'phpmob.form.image.remove_file',
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'phpmob_image';
    }

    /**
     * @return string
     */
    abstract public function getFilterSection();
}
