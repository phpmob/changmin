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
use Sylius\Component\Resource\Repository\RepositoryInterface;

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
    const PREFIX = '@tpl/';

    /**
     * @var RepositoryInterface
     */
    private $repository;

    /**
     * @var array
     */
    private $hits = [];

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
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
        return $name;
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time)
    {
        return $this->getLastUpdated($name) <= $time;
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
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
    private function getLastUpdated($name)
    {
        if (!isset($this->hits[$name])) {
            $this->hits[$name] = $this->findTemplate($name)
                ->getUpdatedAt()
                ->getTimestamp();
        }

        return $this->hits[$name];
    }

    /**
     * @param string $name
     *
     * @return bool|string
     */
    private function getTemplateName($name)
    {
        return substr($name, strlen(self::PREFIX));
    }

    /**
     * @param string $name
     *
     * @return null|object|TemplateInterface
     * @throws \Twig_Error_Loader
     */
    private function findTemplate($name)
    {
        if ($template = $this->repository->findOneBy(['name' => $this->getTemplateName($name)])) {
            return $template;
        }

        throw new \Twig_Error_Loader("Not found template named $name.");
    }
}
