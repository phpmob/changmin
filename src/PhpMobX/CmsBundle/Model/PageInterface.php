<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\CmsBundle\Model;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\SlugAwareInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;
use Sylius\Component\Resource\Model\TranslatableInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface PageInterface extends ResourceInterface, TimestampableInterface, SlugAwareInterface, TranslatableInterface, ToggleableInterface
{
    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param string $title
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getBody();

    /**
     * @param string $body
     */
    public function setBody($body);

    /**
     * @return string
     */
    public function getMetaDescription();

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription);

    /**
     * @return string
     */
    public function getMetaKeywords();

    /**
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords);

    /**
     * @return string
     */
    public function getTemplate();

    /**
     * @param string $template
     */
    public function setTemplate($template);

    /**
     * @return string
     */
    public function getScript();

    /**
     * @param string $script
     */
    public function setScript($script);

    /**
     * @return string
     */
    public function getStyle();

    /**
     * @param string $style
     */
    public function setStyle($style);
}
