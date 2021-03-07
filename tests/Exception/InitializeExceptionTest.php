<?php

namespace tests\Http\Discovery\Exception;

use Http\Discovery\Exception as DiscoveryException;
use PHPUnit\Framework\TestCase;

class InitializeExceptionTest extends TestCase
{
    public function testInitialize()
    {
        $e[] = new DiscoveryException\ClassInstantiationFailedException();
        $e[] = new DiscoveryException\NotFoundException();
        $e[] = new DiscoveryException\StrategyUnavailableException();
        $e[] = new DiscoveryException\NoCandidateFoundException('CommonClasses', []);
        $e[] = DiscoveryException\DiscoveryFailedException::create($e);

        foreach ($e as $exception) {
            $this->assertInstanceOf(\Http\Discovery\Exception::class, $exception);
        }
    }
}
