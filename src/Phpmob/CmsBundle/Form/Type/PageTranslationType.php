<?php

namespace Phpmob\CmsBundle\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PageTranslationType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'phpmob.form.page.title',
                'required' => true,
            ])
            ->add('slug', TextType::class, [
                'label' => 'phpmob.form.page.slug',
                'required' => true,
            ])
            ->add('body', TextareaType::class, [
                'label' => 'phpmob.form.page.body',
                'required' => true,
            ])
            ->add('metaDescription', TextType::class, [
                'label' => 'phpmob.form.page.meta_description',
                'required' => true,
            ])
            ->add('metaKeywords', TextType::class, [
                'label' => 'phpmob.form.page.meta_keywords',
                'required' => true,
            ])
        ;
    }
}
