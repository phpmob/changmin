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

namespace PhpMob\Setting\Manager;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class CachedSettingManager implements SettingManagerInterface
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
     * @param null|UserInterface $user
     *
     * @return string
     */
    private function getCacheKey($section, $key, ?UserInterface $user)
    {
        return 'phpmob-settings.' . ($user
                ? sprintf('%s.%s.%s', $section, $key, $user->getUsername())
                : sprintf('%s.%s', $section, $key)
            );
    }

    /**
     * {@inheritdoc}
     */
    public function setSetting($section, $key, $value, ?UserInterface $user, $autoFlush = false): void
    {
        $cacheKey = $this->getCacheKey($section, $key, $user);

        if ($this->cache->hasItem($cacheKey) && $value === $this->cache->getItem($cacheKey)->get()) {
            return;
        }

        $this->decoratedManager->setSetting($section, $key, $value, $user, $autoFlush);

        $this->cache->save(
            $this->cache->getItem($cacheKey)->set($value)->expiresAfter($this->ttl)
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getSetting($section, $key, ?UserInterface $user)
    {
        $cacheKey = $this->getCacheKey($section, $key, $user);

        if ($this->cache->hasItem($cacheKey)) {
            return $this->cache->getItem($key)->get();
        }

        $value = $this->decoratedManager->getSetting($section, $key, $user);

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
    public function get(string $path, ?UserInterface $user)
    {
        list($section, $key) = explode('.', $path);

        return $this->getSetting($section, $key, $user);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $path, $value, ?UserInterface $user): void
    {
        list($section, $key) = explode('.', $path);

        $this->setSetting($section, $key, $value, $user, true);
    }
}
