<?php

namespace Mundipagg\Core\Test\Payment\ValueObjects;

use Mundipagg\Core\Payment\ValueObjects\CardId;
use PHPUnit\Framework\TestCase;

class CardIdTests extends TestCase
{
    /**
     * @var CardId
     */
    private $cardId;

    public function testCardIdValue()
    {
        $this->cardId = new CardId('card_1234567891111111');

        $this->assertEquals('card_1234567891111111', $this->cardId->getValue());
    }
}
