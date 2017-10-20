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

namespace PhpMob\ChangMinBundle\Fixture;

use Doctrine\Common\Inflector\Inflector;
use Faker\Factory;
use PhpMob\ChangMinBundle\Doctrine\ORM\TaxonRepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class TaxonFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    use LocaleAwareFactoryTrait;

    /**
     * @var FactoryInterface
     */
    private $taxonFactory;

    /**
     * @var TaxonRepositoryInterface
     */
    private $taxonRepository;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @param FactoryInterface $taxonFactory
     * @param TaxonRepositoryInterface $taxonRepository
     */
    public function __construct(
        FactoryInterface $taxonFactory,
        TaxonRepositoryInterface $taxonRepository
    ) {
        $this->taxonFactory = $taxonFactory;
        $this->taxonRepository = $taxonRepository;
        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = [])
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var TaxonInterface $taxon */
        $taxon = $this->taxonRepository->findOneBy(['code' => $options['code']]);

        if (null === $taxon) {
            $taxon = $this->taxonFactory->createNew();
        }

        $taxon->setCode($options['code']);

        $this->setLocalizedData($taxon, ['name', 'slug', 'description'], $options);

        foreach ($options['children'] as $key => $childOptions) {
            $taxon->addChild($this->create($childOptions));
        }

        return $taxon;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefault('name', function (Options $options) {
                return $this->faker->words(3, true);
            })
            ->setDefault('slug', function (Options $options) {
                return $options['name'];
            })
            ->setDefault('code', function (Options $options) {
                return Inflector::ucwords($options['name']);
            })
            ->setDefault('description', function (Options $options) {
                return $this->faker->paragraph;
            })
            ->setDefault('children', [])
            ->setAllowedTypes('children', ['array'])
        ;
    }
}
