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
use Sylius\Component\Resource\Model\TimestampableInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
interface TemplateInterface extends DefinedTranslationInterface, ResourceInterface, TimestampableInterface
{
    const PREFIX = '@tpl/';

    /**
     * @var string extends only
     */
    const TYPE_ABSTRACT = 'a';

    /**
     * @var string full html template
     */
    const TYPE_NORMAL = 'n';

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $name
     */
    public function setName(?string $name);

    /**
     * @return string
     */
    public function getContent(): string;

    /**
     * @param string $content
     */
    public function setContent(?string $content);

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @param string $type
     */
    public function setType(string $type): void;

    /**
     * @return boolean
     */
    public function isAbstractType();

    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @param array $options
     */
    public function setOptions(array $options);

    /**
     * @return string
     */
    public function __toString();
}
