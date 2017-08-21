<?php

namespace PhpMob\CmsBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Bundle\ResourceBundle\Form\Type\ResourceTranslationsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

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
                'required' => false,
                'entry_type' => PageTranslationType::class,
            ])
            ->add('enabled', CheckboxType::class, [
                'label' => 'phpmob.form.page.enabled',
                'required' => false,
            ])
            ->add('template', TextType::class, [
                'label' => 'phpmob.form.page.template',
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
        ;
    }
}
