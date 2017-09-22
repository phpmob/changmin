<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class PageType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('translations', ResourceTranslationsType::class, [
                'label' => 'phpmob.form.page.translations',
                //'label' => false,
                'entry_type' => PageTranslationType::class,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'phpmob.form.page.enabled',
                'required' => false,
            ])
            ->add('template', TemplateChoiceType::class, [
                'label' => 'phpmob.form.page.template',
                'placeholder' => 'phpmob.form.page.template_select',
                'required' => false,
            ])
            ->add('script', TextareaType::class, [
                'label' => 'phpmob.form.page.script',
                'required' => false,
            ])
            ->add('style', TextareaType::class, [
                'label' => 'phpmob.form.page.style',
                'required' => false,
            ])
            ->add('options', YamlType::class, [
                'label' => 'phpmob.form.page.options',
                'required' => false,
            ])
            ->add('userTranslations', YamlType::class, [
                'label' => 'phpmob.form.page.user_translations',
                'required' => false,
            ])
        ;
    }
}
