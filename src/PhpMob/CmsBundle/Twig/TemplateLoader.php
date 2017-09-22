<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Twig;

use PhpMob\CmsBundle\Model\TemplateInterface;
use PhpMob\CmsBundle\Repository\TemplateRepositoryInterface;
use PhpMob\CmsBundle\Translation\AddDefinedTranslationInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 *
 * @TODO work together with SyliusTheme -- if enabled
 */
final class TemplateLoader implements \Twig_LoaderInterface, \Twig_ExistsLoaderInterface
{
    /**
     * @var string
     */
    const PREFIX = TemplateInterface::PREFIX;

    /**
     * @var TemplateRepositoryInterface
     */
    private $repository;

    /**
     * @var AddDefinedTranslationInterface
     */
    private $definedTranslation;

    /**
     * @var array
     */
    private $hits = [];

    public function __construct(
        TemplateRepositoryInterface $repository,
        AddDefinedTranslationInterface $definedTranslation
    ) {
        $this->repository = $repository;
        $this->definedTranslation = $definedTranslation;
    }

    /**
     * {@inheritdoc}
     */
    public function getSourceContext($name)
    {
        return new \Twig_Source((string)$this->findTemplate($name), $name);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($name)
    {
        return (string)$name;
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time)
    {
        return $this->getLastUpdated((string)$name) <= $time;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        $name = (string)$name;

        if (isset($this->hits[$name])) {
            return true;
        }

        try {
            $this->hits[$name] = $this->findTemplate($name);
        } catch (\Twig_Error_Loader $e) {
            return false;
        }

        return true;
    }

    /**
     * @param $name
     *
     * @return integer
     */
    private function getLastUpdated(string $name)
    {
        if (!isset($this->hits[$name])) {
            $this->hits[$name] = $this->findTemplate($name);
        }

        return $this->hits[$name]
            ->getUpdatedAt()
            ->getTimestamp();
    }

    /**
     * @param string $name
     *
     * @return bool|string
     */
    private function getTemplateName(string $name)
    {
        return substr($name, strlen(self::PREFIX));
    }

    /**
     * @param string $name
     *
     * @return null|object|TemplateInterface
     * @throws \Twig_Error_Loader
     */
    private function findTemplate(string $name)
    {
        if (!preg_match(sprintf('|^%s|', preg_quote(self::PREFIX)), $name)) {
            $prefix = self::PREFIX;
            throw new \Twig_Error_Loader("Only supported template starts with $prefix.");
        }

        if ($template = $this->repository->findTemplate($this->getTemplateName($name))) {
            $this->definedTranslation->addTranslations($template);

            return $template;
        }

        throw new \Twig_Error_Loader("Not found template named $name.");
    }
}
