<?php

namespace Mundipagg\Core\Recurrence\Factories;

use Magento\Catalog\Block\Product\Price;
use Mundipagg\Core\Kernel\Abstractions\AbstractModuleCoreSetup as MPSetup;
use Mundipagg\Core\Kernel\Interfaces\FactoryInterface;
use Mundipagg\Core\Recurrence\Aggregates\Plan;
use Mundipagg\Core\Recurrence\Aggregates\SubProduct;
use Mundipagg\Core\Recurrence\ValueObjects\DueValueObject;
use Mundipagg\Core\Recurrence\ValueObjects\IntervalValueObject;
use Mundipagg\Core\Recurrence\ValueObjects\PlanId;
use Mundipagg\Core\Recurrence\ValueObjects\PricingSchemeValueObject as PricingScheme;

class PlanFactory implements FactoryInterface
{
    private $plan;
    private $intervalType;
    private $intervalCount;

    public function __construct()
    {
        $this->plan  = new Plan();
    }

    private function setMundipaggId($postData)
    {
        if (isset($postData['plan_id'])) {
            $this->plan->setMundipaggId(new PlanId($postData['plan_id']));
            return;
        }
    }

    private function setIntervalType($postData)
    {
        if (isset($postData['interval_type'])) {
            $this->intervalType = $postData['interval_type'];
            return;
        }
    }

    private function setIntervalCount($postData)
    {
        if (isset($postData['interval_count'])) {
            $this->intervalCount = $postData['interval_count'];
            return;
        }
    }

    private function setId($postData)
    {
        if (!empty($postData['id'])) {
            $this->plan->setId($postData['id']);
            return;
        }

        $this->plan->setId(null);
    }

    private function setName($postData)
    {
        if (isset($postData['name'])) {
            $this->plan->setName($postData['name']);
            return;
        }
    }

    private function setDescription($postData)
    {
        if (isset($postData['description'])) {
            $this->plan->setDescription($postData['description']);
            return;
        }
    }

    private function setBillingType($postData)
    {
        $this->plan->setBillingType('PREPAID');
    }

    private function setCreditCard($postData)
    {
        if (isset($postData['credit_card'])) {
            $creditCard = $postData['credit_card'] == 'true' ? '1' : '0';
            $this->plan->setCreditCard($creditCard);
            return;
        }
    }

    private function setBoleto($postData)
    {
        if (isset($postData['boleto'])) {
            $boleto = $postData['boleto'] == 'true' ? '1' : '0';
            $this->plan->setBoleto($boleto);
            return;
        }
    }

    private function setAllowInstallments($postData)
    {
        if (isset($postData['installments'])) {
            $installments = $postData['installments'] == 'true' ? '1' : '0';
            $this->plan->setAllowInstallments($installments);
            return;
        }
    }

    private function setProductId($postData)
    {
        if (isset($postData['product_id'])) {
            $this->plan->setProductId($postData['product_id']);
            return;
        }
    }

    private function setUpdatedAt($postData)
    {
        if (isset($postData['updated_at'])) {
            $this->plan->setUpdatedAt(new \Datetime($postData['updated_at']));
            return;
        }
    }

    private function setCreatedAt($postData)
    {
        if (isset($postData['created_at'])) {
            $this->plan->setCreatedAt(new \Datetime($postData['created_at']));
            return;
        }
    }

    private function setStatus($postData)
    {
        if (isset($postData['status'])) {
            $this->plan->setStatus($postData['status']);
            return;
        }
    }

    private function setInterval()
    {
        $intervalCount = $this->intervalCount;
        $intervalType = $this->intervalType;

        if (isset($intervalType) && isset($intervalCount)) {
            $this->plan->setInterval(
                IntervalValueObject::$intervalType($intervalCount)
            );
            return;
        }
    }

    private function setItems($postData)
    {
        if (!empty($postData['items'])) {
            foreach ($postData['items'] as $item) {
                $subProductFactory = new SubProductFactory();
                $subProduct = $subProductFactory->createFromPostData($item);
                $subProduct->setRecurrenceType($this->plan->getRecurrenceType());
                $items[] = $subProduct;
            }

            $this->plan->setItems($items);
            return;
        }
    }

    private function setTrialPeriodDays($postData)
    {
        if (isset($postData['trial_period_days'])) {
            $this->plan->setTrialPeriodDays($postData['trial_period_days']);
            return;
        }

        $this->plan->setTrialPeriodDays(0);
    }

    /**
     *
     * @param  array $postData
     * @return Plan
     */
    public function createFromPostData($postData)
    {
        if (!is_array($postData)) {
            return;
        }

        $this->setMundipaggId($postData);
        $this->setIntervalType($postData);
        $this->setIntervalCount($postData);
        $this->setId($postData);
        $this->setName($postData);
        $this->setDescription($postData);
        $this->setBillingType($postData);
        $this->setCreditCard($postData);
        $this->setBoleto($postData);
        $this->setAllowInstallments($postData);
        $this->setProductId($postData);
        $this->setUpdatedAt($postData);
        $this->setCreatedAt($postData);
        $this->setStatus($postData);
        $this->setInterval();
        $this->setItems($postData);
        $this->setTrialPeriodDays($postData);

        return $this->plan;
    }

    /**
     *
     * @param  array $dbData
     * @return SavedCard
     */
    public function createFromDbData($dbData)
    {
        $plan = new Plan();

        $plan->setId($dbData['id']);

        $plan->setMundipaggId(
            new PlanId($dbData['plan_id'])
        );

        $intervalType = $dbData['interval_type'];
        $intervalCount = $dbData['interval_count'];

        $creditCard = $dbData['credit_card'] === '1' ? '1' : '0';
        $boleto = $dbData['boleto'] === '1' ? '1' : '0';
        $installments = $dbData['installments'] === '1' ? '1' : '0';

        $trialPeriodDays = 0;

        if ($dbData['trial_period_days'] > 0) {
            $trialPeriodDays = $dbData['trial_period_days'];
        }
        $plan->setName($dbData['name']);
        $plan->setDescription($dbData['description']);
        $plan->setBillingType($dbData['billing_type']);
        $plan->setCreditCard($creditCard);
        $plan->setBoleto($boleto);
        $plan->setAllowInstallments($installments);
        $plan->setProductId($dbData['product_id']);
        $plan->setUpdatedAt(new \Datetime($dbData['updated_at']));
        $plan->setCreatedAt(new \Datetime($dbData['created_at']));
        $plan->setStatus($dbData['status']);
        $plan->setInterval(IntervalValueObject::$intervalType($intervalCount));
        $plan->setTrialPeriodDays($trialPeriodDays);

        return $plan;
    }
}
