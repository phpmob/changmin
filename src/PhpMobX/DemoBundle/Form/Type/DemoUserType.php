<?php

namespace PhpMob\DemoBundle\Form\Type;

use Sylius\Bundle\UserBundle\Form\Type\UserType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class DemoUserType extends UserType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('image', DemoUserPictureType::class, [])
            ->add('images', CollectionType::class, [
                'entry_type' => DemoUserPictureType::class,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true,
            ])
        ;
    }
}
