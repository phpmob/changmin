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

namespace PhpMob\Settings\Tests\Schema;

use PhpMob\Settings\Schema\SettingSchemaRegistry;
use PhpMob\Settings\Schema\SettingSchemaRegistryInterface;
use PhpMob\Settings\Tests\FixtureLocal;
use PHPUnit\Framework\TestCase;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class SettingSchemaRegistryTest extends TestCase
{
    /**
     * @var SettingSchemaRegistryInterface
     */
    private $globalRegistry;

    public function setUp(): void
    {
        $this->globalRegistry = new SettingSchemaRegistry(FixtureLocal::onlyGlobalSettings());
    }

    public function tearDown()
    {
        $this->globalRegistry = null;
    }

    public function test_init_global_sections()
    {
        $this->assertEquals(0, count($this->globalRegistry->getOwners()));
        $this->assertEquals(1, count($this->globalRegistry->getGlobals()));
    }

    public function test_get_have_section()
    {
        $sectionName = 'section1';

        $section = $this->globalRegistry->getSection($sectionName);

        $this->assertEquals($sectionName, $section->getName());
    }

    public function test_get_have_section_key()
    {
        $sectionName = 'section1';
        $settingKey = 'foo';

        $section = $this->globalRegistry->getSection($sectionName);

        $this->assertEquals($settingKey, $section->getSetting($settingKey)->getKey());
    }

    public function test_get_have_no_section()
    {
        $sectionName = 'blabla';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No section name `$sectionName`.");

        $this->globalRegistry->getSection($sectionName);
    }

    public function test_get_have_no_section_setting()
    {
        $sectionName = 'section1';
        $settingKey = 'blabla';

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("No setting key `$settingKey` in this section.`");

        $this->globalRegistry->get($sectionName, $settingKey);
    }
}
