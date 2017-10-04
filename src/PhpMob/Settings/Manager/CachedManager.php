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

namespace PhpMob\Settings\Manager;

use Psr\Cache\CacheItemPoolInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class CachedManager implements SettingManagerInterface
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var null|int|\DateInterval
     */
    private $ttl = 0;

    /**
     * @var SettingManagerInterface
     */
    private $decoratedManager;

    public function __construct(SettingManagerInterface $manager, CacheItemPoolInterface $cache, $ttl = 0)
    {
        $this->decoratedManager = $manager;
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    /**
     * @param $section
     * @param $key
     * @param null|string $owner
     *
     * @return string
     */
    private function getCacheKey($section, $key, ?string $owner)
    {
        return 'phpmob-settings.' . ($owner
                ? sprintf('%s.%s.%s', $section, $key, $owner)
                : sprintf('%s.%s', $section, $key)
            );
    }

    /**
     * {@inheritdoc}
     */
    public function setSetting(string $section, string $key, $value, ?string $owner, $autoFlush = false): void
    {
        $cacheKey = $this->getCacheKey($section, $key, $owner);

        if ($this->cache->hasItem($cacheKey) && $value === $this->cache->getItem($cacheKey)->get()) {
            return;
        }

        $this->decoratedManager->setSetting($section, $key, $value, $owner, $autoFlush);

        $this->cache->save(
            $this->cache->getItem($cacheKey)->set($value)->expiresAfter($this->ttl)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getSetting(string $section, string $key, ?string $owner)
    {
        $cacheKey = $this->getCacheKey($section, $key, $owner);

        if ($this->cache->hasItem($cacheKey)) {
            return $this->cache->getItem($cacheKey)->get();
        }

        $value = $this->decoratedManager->getSetting($section, $key, $owner);

        $this->cache->save(
            $this->cache->getItem($cacheKey)->set($value)->expiresAfter($this->ttl)
        );

        return $value;
    }

    /**
     * {@inheritdoc}
     */
    public function flush(): void
    {
        $this->decoratedManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $path, ?string $owner)
    {
        list($section, $key) = explode('.', $path);

        return $this->getSetting($section, $key, $owner);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $path, $value, ?string $owner): void
    {
        list($section, $key) = explode('.', $path);

        $this->setSetting($section, $key, $value, $owner, true);
    }
}
