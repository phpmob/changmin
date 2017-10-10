<?php

declare(strict_types=1);

namespace PhpMob\ChangMinBundle\Fixture;

use PhpMob\ChangMinBundle\Fixture\AbstractExampleFactory;
use PhpMob\ChangMinBundle\Fixture\ExampleFactoryInterface;
use PhpMob\ChangMinBundle\Model\AdminUserInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $userFactory;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @param FactoryInterface $userFactory
     */
    public function __construct(FactoryInterface $userFactory)
    {
        $this->userFactory = $userFactory;

        $this->faker = \Faker\Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = [])
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var AdminUserInterface $user */
        $user = $this->userFactory->createNew();
        $user->setEmail($options['email']);
        $user->setUsername($options['username']);
        $user->setPlainPassword($options['password']);
        $user->setDisplayName($options['displayName']);
        $user->setEnabled($options['enabled']);

        $roles = array_replace(['ROLE_ADMINISTRATION_ACCESS'], $options['roles']);

        foreach ($roles as $role) {
            $user->addRole($role);
        }

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('email', function (Options $options) {
                return $this->faker->email;
            })
            ->setDefault('username', function (Options $options) {
                return $this->faker->userName;
            })
            ->setDefault('displayName', function (Options $options) {
                return $this->faker->name;
            })
            ->setDefault('enabled', true)
            ->setAllowedTypes('enabled', 'bool')
            ->setDefault('password', 'password123')
            ->setDefault('roles', ['ROLE_ADMINISTRATION_ACCESS'])
        ;
    }
}
