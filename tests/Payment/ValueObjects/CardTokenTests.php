<?php

namespace Mundipagg\Core\Test\Payment\ValueObjects;

use Mundipagg\Core\Payment\ValueObjects\CardToken;
use PHPUnit\Framework\TestCase;

class CardTokenTests extends TestCase
{
    /**
     * @var CardToken
     */
    private $cardId;

    public function testCardTokenValue()
    {
        $this->cardId = new CardToken('token_1234567891111111');

        $this->assertEquals('token_1234567891111111', $this->cardId->getValue());
    }
}
