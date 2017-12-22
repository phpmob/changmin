<?php

namespace PhpMob\CoreBundle\Form\Type;

use Sylius\Bundle\LocaleBundle\Form\Type\LocaleChoiceType;
use Sylius\Bundle\UserBundle\Form\Type\UserType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
            ->add('firstName', TextType::class, [
                'label' => 'phpmob.form.user.first_name',
                'required' => false,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'phpmob.form.user.last_name',
                'required' => false,
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'phpmob.form.user.gender',
                'choices' => array_flip([
                    'm' => 'phpmob.form.user.gender_man',
                    'f' => 'phpmob.form.user.gender_female',
                ]),
                'required' => false,
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => 'phpmob.form.user.phone_number',
                'required' => false,
            ])
            ->add('birthday', DateType::class, [
                'label' => 'phpmob.form.user.birthday',
                'widget' => 'single_text',
                'required' => false,
            ])
            ->add('countryCode', CountryType::class, [
                'label' => 'phpmob.form.user.country_code',
                'required' => false,
            ])
            ->add('locale', LocaleChoiceType::class, [
                'label' => 'phpmob.form.user.locale',
                'required' => false,
            ])
            ->add('statusMessage', TextType::class, [
                'label' => 'phpmob.form.user.status_message',
                'required' => false,
            ])
            ->add('displayName', TextType::class, [
                'label' => 'phpmob.form.user.display_name',
                'required' => false,
            ])
            ->add('picture', WebUserPictureType::class, [
                'label' => 'phpmob.form.user.picture',
                'required' => false,
            ])
        ;
    }
}
