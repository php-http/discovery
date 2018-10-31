<?php

namespace spec\Http\Discovery;

use Http\Client\HttpClient;
use Http\Discovery\ClassDiscovery;
use Http\Discovery\NotFoundException;
use Http\Discovery\Strategy\DiscoveryStrategy;
use Puli\GeneratedPuliFactory;
use Puli\Discovery\Api\Discovery;
use Puli\Discovery\Binding\ClassBinding;
use Puli\Repository\Api\ResourceRepository;
use PhpSpec\ObjectBehavior;
use spec\Http\Discovery\Helper\DiscoveryHelper;
use Http\Discovery\HttpClientDiscovery;
use spec\Http\Discovery\Stub\HttpClientStub;
use spec\Http\Discovery\Stub\PSR18ClientStub;

class HttpClientDiscoverySpec extends ObjectBehavior
{
    function let()
    {
        ClassDiscovery::setStrategies([DiscoveryHelper::class]);
        DiscoveryHelper::clearClasses();
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(HttpClientDiscovery::class);
    }

    function it_is_a_class_discovery()
    {
        $this->shouldHaveType(ClassDiscovery::class);
    }

    function it_finds_a_http_client(DiscoveryStrategy $strategy) 
    {
        $candidate = ['class' => HttpClientStub::class, 'condition' => true];
        if ($this->psr18IsInUse()) {
            $candidate['class'] = PSR18ClientStub::class;
        }

        DiscoveryHelper::setClasses(HttpClient::class, [$candidate]);

        $this->find()->shouldImplement(HttpClient::class);
    }

    function it_throw_exception(DiscoveryStrategy $strategy) {
        $this->shouldThrow(NotFoundException::class)->duringFind();
    }

    private function psr18IsInUse()
    {
        if (PHP_MAJOR_VERSION < 7) {
            return false;
        }

        $reflection = new \ReflectionMethod(HttpClient::class, 'sendRequest');
        
        return $reflection->hasReturnType();
    }
}
