<?php

namespace Mundipagg\Core\Test\Payment\Aggregates;

use Exception;
use MundiAPILib\Models\CreateShippingRequest;
use Mundipagg\Core\Payment\Aggregates\Address;
use Mundipagg\Core\Payment\Aggregates\Shipping;
use Mundipagg\Core\Payment\ValueObjects\Phone;
use PHPUnit\Framework\TestCase;

class ShippingTests extends TestCase
{
    /**
     * @var Shipping
     */
    private $shipping;

    public function setUp()
    {
        $this->shipping = new Shipping();
    }

    public function testShippingDescription()
    {
        $this->shipping->setDescription('Flat Rate - Fixed');
        $this->assertEquals('Flat Rate - Fixed', $this->shipping->getDescription());
    }

    public function testShippingRecipientName()
    {
        $this->shipping->setRecipientName('Fulano Tal');
        $this->assertEquals('Fulano Tal', $this->shipping->getRecipientName());
    }

    public function testShippingRecipientPhone()
    {
        $this->shipping->setRecipientPhone(new Phone('2134519090'));
        $phoneObject = $this->shipping->getRecipientPhone();

        $this->assertInternalType('object', $phoneObject);
        $this->assertInstanceOf(Phone::class, $phoneObject);
    }

    public function testShippingAddress()
    {
        $this->shipping->setAddress(new Address());
        $address = $this->shipping->getAddress();

        $this->assertInternalType('object', $address);
        $this->assertInstanceOf(Address::class, $address);
    }

    public function testShippingJsonSerialize()
    {
        $shippingSerialize = $this->shipping->jsonSerialize();
        $this->assertInternalType('object', $shippingSerialize);
        $this->assertInstanceOf(\stdClass::class, $shippingSerialize);
    }

    /**
     * @throws Exception
     */
    public function testShippingConvertToSDKRequestWithSetPhoneAndAddress()
    {
        $this->shipping->setRecipientPhone(new Phone('2134519090'));
        $this->shipping->setAddress(new Address());

        $createShippingRequest = $this->shipping->convertToSDKRequest();
        $this->assertInternalType('object', $createShippingRequest);
        $this->assertInstanceOf(CreateShippingRequest::class, $createShippingRequest);
    }
}
