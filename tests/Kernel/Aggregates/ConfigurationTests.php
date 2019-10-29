<?php

namespace Mundipagg\Core\Test\Kernel\Aggregates;

use Mundipagg\Core\Kernel\Aggregates\Configuration;
use PHPUnit\Framework\TestCase;

class ConfigurationTests extends TestCase
{
    /**
     * @var Configuration
     */
    private $configuration;

    public function setUp()
    {
        $this->configuration = new Configuration();
    }

    public function testIsEnabled()
    {
        $this->configuration->setEnabled(true);
        $this->assertInternalType('bool', $this->configuration->isEnabled());
        $this->assertEquals(true, $this->configuration->isEnabled());
    }

    public function testIsUnabled()
    {
        $this->configuration->setEnabled(false);
        $this->assertInternalType('bool', $this->configuration->isEnabled());
        $this->assertEquals(false, $this->configuration->isEnabled());
    }

    public function testBoletoEnabled()
    {
        $this->configuration->setBoletoEnabled(true);
        $this->assertInternalType('bool', $this->configuration->isBoletoEnabled());
        $this->assertEquals(true, $this->configuration->isBoletoEnabled());
    }

    public function testBoletoUnabled()
    {
        $this->configuration->setBoletoEnabled(false);
        $this->assertInternalType('bool', $this->configuration->isBoletoEnabled());
        $this->assertEquals(false, $this->configuration->isBoletoEnabled());
    }

    public function testCreditCardEnabled()
    {
        $this->configuration->setCreditCardEnabled(true);
        $this->assertInternalType('bool', $this->configuration->isCreditCardEnabled());
        $this->assertEquals(true, $this->configuration->isCreditCardEnabled());
    }

    public function testCreditCardUnabled()
    {
        $this->configuration->setCreditCardEnabled(false);
        $this->assertInternalType('bool', $this->configuration->isCreditCardEnabled());
        $this->assertEquals(false, $this->configuration->isCreditCardEnabled());
    }

    public function testAntifraudEnabled()
    {
        $this->configuration->setAntifraudEnabled(true);
        $this->assertInternalType('bool', $this->configuration->isAntifraudEnabled());
        $this->assertEquals(true, $this->configuration->isAntifraudEnabled());
    }
}
