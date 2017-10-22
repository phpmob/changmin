<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\ChangMinBundle\Form\Type;

use PhpMob\ChangMinBundle\Doctrine\ORM\TaxonRepositoryInterface;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\View\ChoiceView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
final class TaxonChoiceType extends AbstractType
{
    /**
     * @var TaxonRepositoryInterface
     */
    private $taxonRepository;

    /**
     * @param TaxonRepositoryInterface $taxonRepository
     */
    public function __construct(TaxonRepositoryInterface $taxonRepository)
    {
        $this->taxonRepository = $taxonRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $rootLevel = 0;

        /** @var ChoiceView $choice */
        foreach ($view->vars['choices'] as $i => $choice) {
            $dash = '— ';

            if (0 === $i) {
                $rootLevel = $choice->data->getLevel();
            }

            if (preg_match("/^$dash/", $choice->label)) {
                continue;
            }

            $level = $choice->data->getLevel() - $rootLevel;
            $choice->label = @str_repeat($dash, $level).$choice->label;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return EntityType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'choices' => function (Options $options) {
                    return $this->getTaxons($options['root'], $options['filter']);
                },
                'choice_value' => 'id',
                'choice_label' => 'name',
                'choice_translation_domain' => false,
                'root' => null,
                'root_code' => null,
                'filter' => null,
                'class' => $this->taxonRepository->getClassName(),
            ])
            ->setAllowedTypes('root', [TaxonInterface::class, 'string', 'null'])
            ->setAllowedTypes('root_code', ['string', 'null'])
            ->setAllowedTypes('filter', ['callable', 'null'])
            ->setNormalizer('root', function (Options $options, $value) {
                if ($value instanceof TaxonInterface) {
                    return $value->getCode();
                }

                return $value ?: $options['root_code'];
            })
        ;
    }

    /**
     * @param string|null $rootCode
     * @param callable|null $filter
     *
     * @return TaxonInterface[]
     */
    private function getTaxons($rootCode = null, $filter = null)
    {
        $taxons = $this->taxonRepository->findNodesTreeSorted($rootCode);

        if (null !== $filter) {
            $taxons = array_filter($taxons, $filter);
        }

        return $taxons;
    }
}
