<?php

namespace tests\Http\Discovery\Exception;

use Http\Discovery\Exception as DiscoveryException;
use PHPUnit\Framework\TestCase;

class NoCandidateFoundExceptionTest extends TestCase
{
    public function testInitialize()
    {
        $candidates = [
            ['class' => 'Foo', 'condition' => true],
            ['class' => 'Bar', 'condition' => false],
        ];
        $exception = new DiscoveryException\NoCandidateFoundException('Foobar', $candidates);
        $this->assertInstanceOf(\Http\Discovery\Exception::class, $exception);
        $this->assertStringStartsWith('No valid candidate found using strategy "Foobar".', $exception->getMessage());
    }

    public function testInitializeWithArrayCallable()
    {
        $candidates = [
            ['class' => ['AnyClass', 'anyFunction'], 'condition' => true],
        ];

        $exception = new DiscoveryException\NoCandidateFoundException('Foobar', $candidates);
        $this->assertInstanceOf(\Http\Discovery\Exception::class, $exception);
    }

    public function testInitializeWithObjectCallable()
    {
        $obj = new \stdClass();
        $candidates = [
            ['class' => [$obj, 'anyFunction'], 'condition' => true],
        ];

        $exception = new DiscoveryException\NoCandidateFoundException('Foobar', $candidates);
        $this->assertInstanceOf(\Http\Discovery\Exception::class, $exception);
    }

    public function testInitializeWithClosure()
    {
        $obj = \Closure::fromCallable(function () {
            $x = 2;
        });
        $candidates = [
            ['class' => $obj, 'condition' => true],
        ];

        $exception = new DiscoveryException\NoCandidateFoundException('Foobar', $candidates);
        $this->assertInstanceOf(\Http\Discovery\Exception::class, $exception);
    }

    public function testInitializeWithAnonymousFunction()
    {
        $func = function () {
            $x = 2;
        };
        $candidates = [
            ['class' => $func, 'condition' => true],
        ];

        $exception = new DiscoveryException\NoCandidateFoundException('Foobar', $candidates);
        $this->assertInstanceOf(\Http\Discovery\Exception::class, $exception);
    }
}
