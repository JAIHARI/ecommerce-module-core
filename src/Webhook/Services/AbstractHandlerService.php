<?php

namespace Mundipagg\Core\Webhook\Services;

use Mundipagg\Core\Kernel\Abstractions\AbstractModuleCoreSetup as MPSetup;
use Mundipagg\Core\Kernel\Abstractions\AbstractPlatformOrderDecorator;
use Mundipagg\Core\Kernel\Exceptions\InvalidParamException;
use Mundipagg\Core\Kernel\Exceptions\NotFoundException;
use Mundipagg\Core\Kernel\Interfaces\PlatformOrderInterface;
use Mundipagg\Core\Webhook\Aggregates\Webhook;

abstract class AbstractHandlerService
{
    /** @var PlatformOrderInterface */
    protected $order;

    /**
     * @param Webhook $webhook
     * @return mixed
     * @throws InvalidParamException
     * @throws NotFoundException
     */
    public function handle(Webhook $webhook)
    {
        $entityType = $webhook->getType()->getEntityType();
        $validEntity = $this->getValidEntity();
        if ($entityType !== $validEntity) {
            throw new InvalidParamException(
                self::class . ' only supports '. $validEntity .' type webhook handling!',
                $entityType . '.(action)'
            );
        }

        $handler = 'handle' . ucfirst($webhook->getType()->getAction());
        if (method_exists($this, $handler)) {
            $this->loadOrder($webhook);
            $this->addWebHookReceivedHistory($webhook);
            return $this->$handler($webhook);
        }
        $message =
            "Handler for {$webhook->getType()->getEntityType()}." .
            "{$webhook->getType()->getAction()} webhook not found!";

        throw new NotFoundException($message);
    }

    /** @return string */
    protected function getValidEntity()
    {
        $childClassName = substr(strrchr(static::class, "\\"), 1);
        $childEntity = str_replace('HandlerService','',$childClassName);
        return strtolower($childEntity);
    }

    protected function addWebHookReceivedHistory(Webhook $webhook)
    {
        $message = 'Webhook received: ' .
            $webhook->getType()->getEntityType() . '.' .
            $webhook->getType()->getAction();

        $this->order->addHistoryComment($message);
    }

    abstract protected function loadOrder($webhook);
}