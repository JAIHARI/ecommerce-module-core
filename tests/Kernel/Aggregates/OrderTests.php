<?php

namespace Mundipagg\Core\Test\Kernel\Aggregates;

use Mundipagg\Core\Kernel\Aggregates\Charge;
use Mundipagg\Core\Kernel\Aggregates\Order;
use Mundipagg\Core\Kernel\Interfaces\PlatformOrderInterface;
use Mundipagg\Core\Kernel\ValueObjects\Id\ChargeId;
use Mundipagg\Core\Kernel\ValueObjects\Id\CustomerId;
use Mundipagg\Core\Kernel\ValueObjects\Id\OrderId;
use Mundipagg\Core\Kernel\ValueObjects\OrderStatus;
use Mundipagg\Core\Payment\Aggregates\Customer;
use PHPUnit\Framework\TestCase;

class OrderTests extends TestCase
{
    /**
     * @var Order
     */
    private $order;

    public function setUp()
    {
        $this->order = new Order();
    }

    public function testOrderWithCustomer()
    {
        $customer = new Customer();
        $this->order->setCustomer($customer);
        $customerObject = $this->order->getCustomer();

        $this->assertInternalType('object', $customerObject);
        $this->assertInstanceOf(Customer::class, $customerObject);
    }

    public function testOrderBasicSetting()
    {
        /** @var PlatformOrderInterface $mockPlatformOrderInterface */
        $mockPlatformOrderInterface = $this->getMockBuilder(PlatformOrderInterface::class)->getMock();
        $mockPlatformOrderInterface
            ->expects($this->any())
            ->method('getCode')
            ->will($this->returnValue(19738937));

        $charge1 = new Charge();
        $charge1->setAmount(1000);
        $charge1->setMundipaggId(new ChargeId('ch_K7dX521DDDTZnjM4'));

        $charge2 = new Charge();
        $charge2->setAmount(2000);
        $charge2->setMundipaggId(new ChargeId('ch_K7d56ghDDDTZnj89'));

        $this->order->setId(16);
        $this->order->setPlatformOrder($mockPlatformOrderInterface);
        $this->order->setCustomer(new Customer());
        $this->order->setMundipaggId(new OrderId('or_K7dX521DDDTZnjM4'));
        $this->order->addCharge($charge1);
        $this->order->addCharge($charge2);
        $this->order->updateCharge($charge2);
        $this->order->setStatus(OrderStatus::processing());

        //tests
        $this->assertEquals(19738937, $this->order->getCode());
        $this->assertEquals(3000, $this->order->getAmount());
        $this->assertInternalType('object', $this->order);
        $this->assertInstanceOf(Order::class, $this->order);
        $this->assertInstanceOf(PlatformOrderInterface::class, $this->order->getPlatformOrder());
        $this->assertInstanceOf(OrderStatus::class, $this->order->getStatus());
        $this->assertInstanceOf(\stdClass::class, $this->order->jsonSerialize());
    }
}
