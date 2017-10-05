<?php

namespace PhpMob\CoreBundle\Form\Type;

use Sylius\Bundle\UserBundle\Form\Type\UserType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class WebUserType extends UserType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('picture', WebUserPictureType::class, [
                'label' => 'phpmob.form.user.picture',
                'required' => false,
            ])
            ->add('statusMessage', TextType::class, [
                'label' => 'phpmob.form.user.status_message',
                'required' => false,
            ])
        ;
    }
}
