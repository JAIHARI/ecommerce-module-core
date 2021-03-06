<?php

namespace Mundipagg\Core\Test\Kernel\ValueObjects;

use Mundipagg\Core\Kernel\ValueObjects\OrderStatus;
use PHPUnit\Framework\TestCase;

class OrderStatusTest extends TestCase
{
    /**
     *
     * For the valid charge statuses list, check
     * ({@link https://docs.mundipagg.com/v1/reference#cobran%C3%A7as})
     *
     */
    protected $validStatuses = [
        'paid',
        'pending',
        'canceled',
        'processing',
        'failed'
    ];

    /**
     * @test
     *
     * @covers \Mundipagg\Core\Kernel\ValueObjects\OrderStatus
     *
     * @uses \Mundipagg\Core\Kernel\Abstractions\AbstractValueObject
     *
     */
    public function aOrderStatusShouldBeComparable()
    {
        $OrderStatusPaid1 = OrderStatus::paid();
        $OrderStatusPaid2 = OrderStatus::paid();

        $OrderStatusPending2 = OrderStatus::pending();

        $this->assertTrue($OrderStatusPaid1->equals($OrderStatusPaid2));
        $this->assertFalse($OrderStatusPaid1->equals($OrderStatusPending2));
        $this->assertFalse($OrderStatusPaid2->equals($OrderStatusPending2));
    }

    /**
     * @test
     *
     * @covers \Mundipagg\Core\Kernel\ValueObjects\OrderStatus
     */
    public function aOrderStatusShouldBeJsonSerializable()
    {
        $OrderStatusPaid1 = OrderStatus::paid();

        $json = json_encode($OrderStatusPaid1);
        $expected = json_encode(OrderStatus::PAID);

        $this->assertEquals($expected, $json);
    }

    /**
     * @test
     *
     * @covers \Mundipagg\Core\Kernel\ValueObjects\OrderStatus
     */
    public function allOrderStatusConstantsDefinedInTheClassShouldBeInstantiable()
    {
        $OrderStatusPaid = OrderStatus::paid();

        $reflectionClass = new \ReflectionClass($OrderStatusPaid);
        $constants = $reflectionClass->getConstants();

        foreach ($constants as $brand) {
            $OrderStatus = OrderStatus::$brand();
            $this->assertEquals($brand, $OrderStatus->getStatus());
        }
    }

    /**
     * @test
     *
     * @covers \Mundipagg\Core\Kernel\ValueObjects\OrderStatus
     */
    public function aInvalidOrderStatusShouldNotBeInstantiable()
    {
        $OrderStatusClass = OrderStatus::class;
        $invalidOrderStatus = OrderStatus::PAID . OrderStatus::PAID;

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Call to undefined method {$OrderStatusClass}::{$invalidOrderStatus}()");

        $OrderStatusPaid = OrderStatus::$invalidOrderStatus();
    }

    /**
     * @test
     *
     * @covers \Mundipagg\Core\Kernel\ValueObjects\OrderStatus
     */
    public function aOrderStatusShouldAcceptAllPossibleOrderStatuses()
    {
        foreach ($this->validStatuses as $validStatus) {
            $orderStatus = OrderStatus::$validStatus();

            $this->assertEquals($validStatus, $orderStatus->getStatus());
        }
    }

    /**
     * @test
     *
     * @covers \Mundipagg\Core\Kernel\ValueObjects\OrderStatus::pendingPayment
     *
     * @uses \Mundipagg\Core\Kernel\ValueObjects\OrderStatus
     * @uses \Mundipagg\Core\Kernel\Abstractions\AbstractValueObject
     */
    public function PendingPaymentShouldBeEqualsToPending()
    {
        $pending = Orderstatus::pending();
        $pendingPayment = OrderStatus::pendingPayment();

        $this->assertTrue($pendingPayment->equals($pending));
    }
}
