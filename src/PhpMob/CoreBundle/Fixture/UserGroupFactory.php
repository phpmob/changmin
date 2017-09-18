<?php

declare(strict_types=1);

namespace PhpMob\CoreBundle\Fixture;

use PhpMob\ChangMinBundle\Fixture\AbstractExampleFactory;
use PhpMob\ChangMinBundle\Fixture\ExampleFactoryInterface;
use PhpMob\CoreBundle\Model\UserGroupInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserGroupFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    /**
     * @var FactoryInterface
     */
    private $userGroupFactory;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @param FactoryInterface $userGroupFactory
     */
    public function __construct(FactoryInterface $userGroupFactory)
    {
        $this->userGroupFactory = $userGroupFactory;

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

        /** @var UserGroupInterface $group */
        $group = $this->userGroupFactory->createNew();
        $group->setCode($options['code']);
        $group->setName($options['name']);

        return $group;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('code', function (Options $options) {
                return $this->faker->word;
            })
            ->setDefault('name', function (Options $options) {
                return $this->faker->word;
            })
        ;
    }
}
