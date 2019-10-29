<?php

namespace Mundipagg\Core\Test\Payment\Factories;

use Mundipagg\Core\Payment\Factories\AddressFactory;
use PHPUnit\Framework\TestCase;
use Mundipagg\Core\Payment\Aggregates\Address;

class AddressFactoryTests extends TestCase
{
    /**
     * @var AddressFactory
     */
    private $addressFactory;

    public function setUp()
    {
        $this->addressFactory = new AddressFactory();
    }

    public function testAddressFactoryCreateFromJson()
    {
        $jsonAddressJson = '{"street": "Rua 1", "number": "120", "neighborhood": "La Paz", "complement": "Fundos", "city": "Rio de Janeiro", "state": "Rio de JK", "zipCode": "21241300"}';
        $address = $this->addressFactory->createFromJson($jsonAddressJson);

        $this->assertInternalType('object', $address);
        $this->assertInstanceOf(Address::class, $address);
    }
}
