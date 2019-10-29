<?php

namespace Mundipagg\Core\Test\Kernel\Exceptions;

use Mundipagg\Core\Kernel\Exceptions\InvalidOperationException;
use Mundipagg\Core\Kernel\Exceptions\InvalidParamException;
use PHPUnit\Framework\TestCase;

class InvalidOperationExceptionTests extends TestCase
{

    public function testInstanceInvalidOperationException()
    {
        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage('message here!!!');
        $this->expectExceptionCode(400);

        throw new InvalidOperationException("message here!!!", 400);
    }
}
