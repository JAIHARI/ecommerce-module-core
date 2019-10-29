<?php

namespace Mundipagg\Core\Test\Payment\Aggregates;

use Mundipagg\Core\Payment\Aggregates\Address;
use PHPUnit\Framework\TestCase;

class AddressTests extends TestCase
{
    /**
     * @var Address
     */
    private $andress;

    public function setUp()
    {
        $this->andress = new Address();
    }

    public function testAddressNumberRemoveComma()
    {
        $this->andress->setNumber('12,3,4,5,6');
        $this->assertEquals('123456', $this->andress->getNumber());
    }

    public function testStreetAddress()
    {
        $this->andress->setStreet('Rua Acre');
        $this->assertEquals('Rua Acre', $this->andress->getStreet());
    }

    public function testNeighborhoodAddress()
    {
        $this->andress->setNeighborhood('São Luis');
        $this->assertEquals('São Luis', $this->andress->getNeighborhood());
    }

    public function testComplementAddress()
    {
        $this->andress->setComplement('Fundos');
        $this->assertEquals('Fundos', $this->andress->getComplement());
    }

    public function testZipCodeAddress()
    {
        $this->andress->setZipCode('21241300');
        $this->assertEquals('21241300', $this->andress->getZipCode());
    }

    public function testCityAddress()
    {
        $this->andress->setCity('Rio de Janeiro');
        $this->assertEquals('Rio de Janeiro', $this->andress->getCity());
    }

    public function testCountryAddress()
    {
        $this->andress->setCountry('Brazil');
        $this->assertEquals('Br', $this->andress->getCountry());
    }

    public function testStateAddress()
    {
        $this->andress->setState('Rio de Janeiro');
        $this->assertEquals('Ri', $this->andress->getState());
    }
}
