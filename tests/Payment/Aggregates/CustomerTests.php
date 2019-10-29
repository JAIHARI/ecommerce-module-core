<?php

namespace Mundipagg\Core\Test\Payment\Aggregates;

use MundiAPILib\Models\CreateCustomerRequest;
use Mundipagg\Core\Kernel\ValueObjects\Id\CustomerId;
use Mundipagg\Core\Payment\Aggregates\Address;
use Mundipagg\Core\Payment\Aggregates\Customer;
use Mundipagg\Core\Payment\ValueObjects\CustomerPhones;
use Mundipagg\Core\Payment\ValueObjects\CustomerType;
use Mundipagg\Core\Payment\ValueObjects\Phone;
use PHPUnit\Framework\TestCase;

class CustomerTests extends TestCase
{
    /**
     * @var Customer
     */
    private $customer;

    public function setUp()
    {
        $this->customer = new Customer();
    }

    public function testBuildCustomerObject()
    {
        $this->customer->setCode(2);
        $this->customer->setMundipaggId(new CustomerId('cus_K7dX521DDDTZnjM4'));
        $this->customer->setName('Wallace Ferreira');
        $this->customer->setEmail('wallace@teste.com');
        $this->customer->setDocument('76852559017');
        $this->customer->setType(CustomerType::individual());
        $this->customer->setAddress(new Address());

        $phone = new Phone('2134519090');
        $this->customer->setPhones(CustomerPhones::create([$phone, $phone]));

        $this->assertInstanceOf(
            CustomerPhones::class,
            $this->customer->getPhones()
        );

        $this->assertInstanceOf(
            Address::class,
            $this->customer->getAddress()
        );

        $this->assertEquals(2, $this->customer->getCode());
        $this->assertEquals('cus_K7dX521DDDTZnjM4', $this->customer->getMundipaggId());
        $this->assertEquals('Wallace Ferreira', $this->customer->getName());
        $this->assertEquals('wallace@teste.com', $this->customer->getEmail());
        $this->assertEquals('76852559017', $this->customer->getDocument());
        $this->assertEquals(CustomerType::individual(), $this->customer->getType());
    }

    public function testBuildCustomerConvertToSDKRequest()
    {
        $customerRequest = $this->customer->convertToSDKRequest();
        $this->assertInternalType('object', $customerRequest);
        $this->assertInstanceOf(CreateCustomerRequest::class, $customerRequest);
    }

    public function testBuildCustomerJsonSerialize()
    {
        $customerSerialize = $this->customer->jsonSerialize();
        $this->assertInternalType('object', $customerSerialize);
        $this->assertInstanceOf(\stdClass::class, $customerSerialize);
    }
}
