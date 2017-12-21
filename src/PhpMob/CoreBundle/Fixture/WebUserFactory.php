<?php

declare(strict_types=1);

namespace PhpMob\CoreBundle\Fixture;

use PhpMob\CoreBundle\Model\WebUserInterface;
use PhpMob\ChangMinBundle\Fixture\AbstractExampleFactory;
use PhpMob\ChangMinBundle\Fixture\ExampleFactoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Webmozart\Assert\Assert;

class WebUserFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /**
     * @var RepositoryInterface
     */
    private $localeRepository;

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

    public function __construct(FactoryInterface $userFactory, RepositoryInterface $localeRepository)
    {
        $this->userFactory = $userFactory;
        $this->localeRepository = $localeRepository;

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

        /** @var WebUserInterface $user */
        $user = $this->userFactory->createNew();
        $user->setEmail($options['email']);
        $user->setUsername($options['username']);
        $user->setPlainPassword($options['password']);
        $user->setDisplayName($options['displayName']);
        $user->setEnabled($options['enabled']);
        $user->setFirstName($options['firstName']);
        $user->setLastName($options['lastName']);
        $user->setPhoneNumber($options['phoneNumber']);
        $user->setCountryCode($options['countryCode']);
        $user->setLocaleCode($options['localeCode']);
        $user->setBirthday($options['birthday']);
        $user->addRole('ROLE_USER');

        return $user;
    }

    public static function randomOneLocaleCode(RepositoryInterface $repository): \Closure
    {
        return function (Options $options) use ($repository) {
            $objects = $repository->findAll();

            if ($objects instanceof Collection) {
                $objects = $objects->toArray();
            }

            Assert::notEmpty($objects);

            return $objects[array_rand($objects)]->getCode();
        };
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
            ->setDefault('firstName', function (Options $options) {
                return $this->faker->firstName;
            })
            ->setDefault('lastName', function (Options $options) {
                return $this->faker->lastName;
            })
            ->setDefault('phoneNumber', function (Options $options) {
                return $this->faker->phoneNumber;
            })
            ->setDefault('birthday', function (Options $options) {
                return $this->faker->dateTime;
            })
            ->setDefault('countryCode', function (Options $options) {
                return $this->faker->countryCode;
            })
            ->setDefault('localeCode', self::randomOneLocaleCode($this->localeRepository))
            ->setDefault('enabled', true)
            ->setAllowedTypes('enabled', 'bool')
            ->setDefault('password', 'password123')
        ;
    }
}
