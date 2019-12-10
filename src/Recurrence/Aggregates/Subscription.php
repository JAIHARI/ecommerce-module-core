<?php

namespace Mundipagg\Core\Recurrence\Aggregates;

use MundiAPILib\Models\CreateOrderRequest;
use MundiAPILib\Models\CreateSubscriptionRequest;
use Mundipagg\Core\Kernel\Abstractions\AbstractEntity;
use Mundipagg\Core\Kernel\Aggregates\Order;
use Mundipagg\Core\Kernel\Interfaces\PlatformOrderInterface;
use Mundipagg\Core\Kernel\ValueObjects\Id\SubscriptionId;
use Mundipagg\Core\Payment\Traits\WithCustomerTrait;
use Mundipagg\Core\Recurrence\ValueObjects\SubscriptionStatus;
use Mundipagg\Core\Kernel\ValueObjects\PaymentMethod;
use Mundipagg\Core\Recurrence\ValueObjects\Id\PlanId;
use Mundipagg\Core\Recurrence\ValueObjects\IntervalValueObject;
use Mundipagg\Core\Recurrence\Aggregates\SubProduct;

class Subscription extends AbstractEntity
{
    use WithCustomerTrait;

    const RECURRENCE_TYPE = "subscription";

    /**
     * @var SubscriptionId
     */
    private $subscriptionId;

    /**
     * @var string
     */
    private $code;

    /**
     * @var SubscriptionStatus
     */
    private $status;

    /**
     * @var int
     */
    private $installments;

    /**
     * @var PaymentMethod
     */
    private $paymentMethod;

    private $intervalType;

    private $intervalCount;

    /**
     * @var PlanId
     */
    private $planId;

    /**
     * @var Order
     */
    private $platformOrder;
    private $items;
    private $cycle;
    private $billingType;
    private $cardToken;
    private $boletoDays;
    private $cardId;

    /**
     * @return mixed
     */
    public function getBillingType()
    {
        return $this->billingType;
    }

    /**
     * @param mixed $billingType
     */
    public function setBillingType($billingType)
    {
        $this->billingType = $billingType;
        return $this;
    }

    /**
     * @return SubscriptionId
     */
    public function getSubscriptionId()
    {
        return $this->subscriptionId;
    }

    /**
     * @param  SubscriptionId $subscriptionId
     * @return $this
     */
    public function setSubscriptionId(SubscriptionId $subscriptionId)
    {
        $this->subscriptionId = $subscriptionId;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param  string $code
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param SubscriptionStatus $status
     * @return $this
     */
    public function setStatus(SubscriptionStatus $status)
    {
        $this->status = $status;
        return $this;
    }

    public function setInstallments($installments)
    {
        $this->installments = $installments;
        return $this;
    }

    public function getInstallments()
    {
        return $this->installments;
    }

    public function setPaymentMethod(PaymentMethod $paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;
        return $this;
    }

    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    public function getRecurrenceType()
    {
        return self::RECURRENCE_TYPE;
    }

    public function setIntervalType($intervalType)
    {
        $this->intervalType = $intervalType;
        return $this;
    }

    public function getIntervalType()
    {
        return $this->intervalType;
    }

    public function setIntervalCount($intervalCount)
    {
        $this->intervalCount = $intervalCount;
        return $this;
    }

    public function getIntervalCount()
    {
        return $this->intervalType;
    }

    public function setPlanId(PlanId $planId)
    {
        $this->planId = $planId;
        return $this;
    }

    public function getPlanId()
    {
        return $this->planId;
    }

    /**
     *
     * @return Order
     */
    public function getPlatformOrder()
    {
        return $this->platformOrder;
    }

    /**
     *
     * @param PlatformOrderInterface $platformOrder
     * @return Subscription
     */
    public function setPlatformOrder(PlatformOrderInterface $platformOrder)
    {
        $this->platformOrder = $platformOrder;
        return $this;
    }

    /**
     *
     * @return Cycle
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     *
     * @param Cycle $cycle
     * @return Subscription
     */
    public function setCycle(Cycle $cycle)
    {
        $this->cycle = $cycle;
        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getCardToken()
    {
        return $this->cardToken;
    }

    /**
     * @param mixed $cardToken
     */
    public function setCardToken($cardToken)
    {
        $this->cardToken = $cardToken;
    }

    /**
     * @return mixed
     */
    public function getBoletoDays()
    {
        return $this->boletoDays;
    }

    /**
     * @param mixed $boletoDays
     */
    public function setBoletoDays($boletoDays)
    {
        $this->boletoDays = $boletoDays;
    }

    /**
     * @return mixed
     */
    public function getCardId()
    {
        return $this->cardId;
    }

    /**
     * @param mixed $cardId
     */
    public function setCardId($cardId)
    {
        $this->cardId = $cardId;
    }

    public function convertToSdkRequest()
    {
        $subscriptionRequest = new CreateSubscriptionRequest();

        $subscriptionRequest->code = $this->getCode();
        $subscriptionRequest->customer = $this->getCustomer()->convertToSDKRequest();
        $subscriptionRequest->billingType = $this->getBillingType();
        $subscriptionRequest->interval = $this->getIntervalType();
        $subscriptionRequest->intervalCount = $this->getIntervalCount();
        $subscriptionRequest->cardToken = $this->getCardToken();
        $subscriptionRequest->cardId = $this->getCardId();
        $subscriptionRequest->installments = $this->getInstallments();
        $subscriptionRequest->boletoDueDays = $this->getBoletoDays();

        $subscriptionRequest->items = [];
        foreach ($this->getItems() as $item) {
            $subscriptionRequest->items[] = $item->convertToSDKRequest();
        }

        /*$shipping = $this->getShipping();
        if ($shipping !== null) {
            $subscriptionRequest->shipping = $shipping->convertToSDKRequest();
        }*/

        return $subscriptionRequest;
    }

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}