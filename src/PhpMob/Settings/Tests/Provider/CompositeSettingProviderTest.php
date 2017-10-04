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

namespace PhpMob\Settings\Tests\Provider;

use Doctrine\Common\Collections\ArrayCollection;
use PhpMob\Settings\Model\SettingInterface;
use PhpMob\Settings\Provider\CompositeSettingProvider;
use PhpMob\Settings\Provider\LocalSettingProvider;
use PhpMob\Settings\Provider\RemoteSettingProvider;
use PhpMob\Settings\Provider\SettingProviderInterface;
use PhpMob\Settings\Schema\SettingSchemaRegistry;
use PhpMob\Settings\Schema\SettingSchemaRegistryInterface;
use PhpMob\Settings\Tests\FixtureLocal;
use PhpMob\Settings\Tests\FixtureRemote;
use PHPUnit\Framework\TestCase;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class CompositeSettingProviderTest extends TestCase
{
    /**
     * @var SettingSchemaRegistryInterface
     */
    private $settingSchemaRegistry;

    /**
     * @var SettingProviderInterface
     */
    private $localProvider;

    /**
     * @var SettingProviderInterface|\PHPUnit_Framework_MockObject_MockObject
     */
    private $remoteProvider;

    /**
     * @var SettingProviderInterface
     */
    private $compositeProvider;

    public function setUp(): void
    {
        $this->settingSchemaRegistry = new SettingSchemaRegistry(FixtureLocal::allSettings());
        $this->localProvider = new LocalSettingProvider($this->settingSchemaRegistry);
        $this->remoteProvider = $this->createMock(RemoteSettingProvider::class);
        $this->compositeProvider = new CompositeSettingProvider($this->localProvider, $this->remoteProvider);
    }

    public function tearDown()
    {
        $this->settingSchemaRegistry = null;
        $this->localProvider = null;
        $this->remoteProvider = null;
        $this->compositeProvider = null;
    }

    public function test_init_local_section_settings()
    {
        $this->assertEquals(4, count($this->settingSchemaRegistry->getAll()));
        $this->assertEquals(3, count($this->settingSchemaRegistry->getOwners()));
        $this->assertEquals(1, count($this->settingSchemaRegistry->getGlobals()));
    }

    public function test_init_user_settings()
    {
        $settings = new ArrayCollection(FixtureRemote::onlyOwnerSettings());

        $this->remoteProvider
            ->method('findUserSettings')
            ->willReturn($settings)
        ;

        $this->assertEquals(6, $this->compositeProvider->findUserSettings(FixtureRemote::TEST_USER_OWNER)->count());

        $settings->add(FixtureRemote::createModel('section6', 'foo', 'foo_value', FixtureRemote::TEST_USER_OWNER));

        $this->remoteProvider
            ->method('findUserSettings')
            ->willReturn($settings)
        ;

        $this->assertEquals(7, $this->compositeProvider->findUserSettings(FixtureRemote::TEST_USER_OWNER)->count());
    }

    public function test_init_global_settings()
    {
        $settings = new ArrayCollection(FixtureRemote::onlyGlobalSettings());

        $this->remoteProvider
            ->method('findGlobalSettings')
            ->willReturn($settings)
        ;

        $this->assertEquals(4, $this->compositeProvider->findGlobalSettings()->count());

        $settings->add(FixtureRemote::createModel('section6', 'foo', 'foo_value'));

        $this->remoteProvider
            ->method('findGlobalSettings')
            ->willReturn($settings)
        ;

        $this->assertEquals(5, $this->compositeProvider->findGlobalSettings()->count());
    }

    public function test_remote_highter_priority_setting()
    {
        $settings = new ArrayCollection(FixtureRemote::onlyOwnerSettings());
        $settings->add(FixtureRemote::createModel('section6', 'foo', 'foo_value', FixtureRemote::TEST_USER_OWNER));

        $this->remoteProvider
            ->method('findUserSettings')
            ->willReturn($settings)
        ;

        $finalSettings = $this->compositeProvider->findUserSettings(FixtureRemote::TEST_USER_OWNER);

        $sectionA = $finalSettings->filter(function (SettingInterface $setting) {
            return 'section2' === $setting->getSection();
        })->first();

        $sectionNotInRemote = $finalSettings->filter(function (SettingInterface $setting) {
            return 'section8' === $setting->getSection();
        })->first();

        $this->assertEquals('foo_value_remote', $sectionA->getValue());
        $this->assertEquals('foo_value', $sectionNotInRemote->getValue());
    }
}
