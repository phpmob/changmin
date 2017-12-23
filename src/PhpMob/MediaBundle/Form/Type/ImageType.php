<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpMob\MediaBundle\Form\Type;

use PhpMob\MediaBundle\Form\DataTransformer\ImageTypeTransformer;
use PhpMob\MediaBundle\Registry\ImageTypeRegistry;
use PhpMob\MediaBundle\Util\Base64ToFile;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
            ->addEventListener(FormEvents::PRE_SUBMIT, [$this, 'convertBase64ImageListener'])
            ->add('file', FileType::class, [
                'label' => 'phpmob.form.image.file',
                'attr' => ['accept' => 'image/*'],
                'required' => false,
            ])
            ->add('caption', TextType::class, [
                'label' => 'phpmob.form.image.caption',
                'attr' => [
                    'placeholder' => 'phpmob.form.image.caption',
                ],
                'required' => false,
            ])
            ->add('shouldRemove', CheckboxType::class, [
                'label' => 'phpmob.form.image.remove_file',
                'required' => false,
            ])
        ;
    }

    /**
     * @param FormEvent $event
     */
    public function convertBase64ImageListener(FormEvent $event): void
    {
        $data = $event->getData();

        if (is_string($base64String = $data['file'])) {
            $data['file'] = Base64ToFile::createUploadedFile($data['file']);

            $event->setData($data);
        }
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
