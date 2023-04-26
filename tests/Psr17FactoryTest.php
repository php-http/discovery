<?php

namespace tests\Http\Discovery;

use Http\Discovery\Psr17Factory;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Message\UriInterface;

class Psr17FactoryTest extends TestCase
{
    protected function setUp(): void
    {
        if (!interface_exists(RequestFactoryInterface::class)) {
            $this->markTestSkipped(RequestFactoryInterface::class.' required.');
        }
    }

    public function testRequest()
    {
        $request = (new Psr17Factory())->createRequest('GET', '/foo');

        $this->assertInstanceOf(RequestInterface::class, $request);
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('/foo', (string) $request->getUri());
    }

    public function testRequestUri()
    {
        $factory = new Psr17Factory();
        $request = $factory->createRequest('GET', $factory->createUri('/foo'));

        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('/foo', (string) $request->getUri());
    }

    public function testResponse()
    {
        $response = (new Psr17Factory())->createResponse(202);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(202, $response->getStatusCode());
    }

    public function testReasonPhrase()
    {
        $response = (new Psr17Factory())->createResponse(202, 'Hello');

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(202, $response->getStatusCode());
        $this->assertSame('Hello', $response->getReasonPhrase());
    }

    public function testServerRequest()
    {
        $request = (new Psr17Factory())->createServerRequest('GET', '/foo');

        $this->assertInstanceOf(ServerRequestInterface::class, $request);
        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('/foo', (string) $request->getUri());
    }

    public function testServerRequestUri()
    {
        $factory = new Psr17Factory();
        $request = $factory->createServerRequest('GET', $factory->createUri('/foo'));

        $this->assertSame('GET', $request->getMethod());
        $this->assertSame('/foo', (string) $request->getUri());
    }

    public function testServerParam()
    {
        $request = (new Psr17Factory())->createServerRequest('POST', '/foo', ['FOO' => 'bar']);

        $this->assertSame('POST', $request->getMethod());
        $this->assertSame('/foo', (string) $request->getUri());
        $this->assertSame(['FOO' => 'bar'], $request->getServerParams());
    }

    public function testStreamString()
    {
        $stream = (new Psr17Factory())->createStream('Hello');

        $this->assertInstanceOf(StreamInterface::class, $stream);
        $this->assertSame('Hello', (string) $stream);
    }

    public function testStreamFile()
    {
        $stream = (new Psr17Factory())->createStreamFromFile(__FILE__, 'r');

        $this->assertStringEqualsFile(__FILE__, (string) $stream);
    }

    public function testStreamResource()
    {
        $stream = (new Psr17Factory())->createStreamFromResource(fopen(__FILE__, 'r'));

        $this->assertStringEqualsFile(__FILE__, (string) $stream);
    }

    public function testUploadedFile()
    {
        $factory = new Psr17Factory();
        $file = $factory->createUploadedFile($factory->createStream('Hello'), null, \UPLOAD_ERR_PARTIAL, 'client.name', 'client/type');

        $this->assertInstanceOf(UploadedFileInterface::class, $file);
        $this->assertSame(5, $file->getSize());
        $this->assertSame(\UPLOAD_ERR_PARTIAL, $file->getError());
        $this->assertSame('client.name', $file->getClientFilename());
        $this->assertSame('client/type', $file->getClientMediaType());
    }

    public function testUri()
    {
        $uri = (new Psr17Factory())->createUri('/hello');

        $this->assertInstanceOf(UriInterface::class, $uri);
        $this->assertSame('/hello', (string) $uri);
    }

    public function testUriEmpty()
    {
        $uri = (new Psr17Factory())->createUri();

        $this->assertSame('', $uri->getPath());
    }

    // The methods below come from the guzzlehttp/psr7 package and are subject to the following notice:
    //
    // Copyright (c) 2015 Michael Dowling, https://github.com/mtdowling <mtdowling@gmail.com>
    //
    // Permission is hereby granted, free of charge, to any person obtaining a copy
    // of this software and associated documentation files (the "Software"), to deal
    // in the Software without restriction, including without limitation the rights
    // to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    // copies of the Software, and to permit persons to whom the Software is
    // furnished to do so, subject to the following conditions:
    //
    // The above copyright notice and this permission notice shall be included in
    // all copies or substantial portions of the Software.
    //
    // THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    // IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    // FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    // AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    // LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    // OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    // THE SOFTWARE.

    public static function dataGetUriFromGlobals(): iterable
    {
        $server = [
            'REQUEST_URI' => '/blog/article.php?id=10&user=foo',
            'SERVER_PORT' => '443',
            'SERVER_ADDR' => '217.112.82.20',
            'SERVER_NAME' => 'www.example.org',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'REQUEST_METHOD' => 'POST',
            'QUERY_STRING' => 'id=10&user=foo',
            'DOCUMENT_ROOT' => '/path/to/your/server/root/',
            'HTTP_HOST' => 'www.example.org',
            'HTTPS' => 'on',
            'REMOTE_ADDR' => '193.60.168.69',
            'REMOTE_PORT' => '5390',
            'SCRIPT_NAME' => '/blog/article.php',
            'SCRIPT_FILENAME' => '/path/to/your/server/root/blog/article.php',
            'PHP_SELF' => '/blog/article.php',
        ];

        return [
            'HTTPS request' => [
                'https://www.example.org/blog/article.php?id=10&user=foo',
                $server,
            ],
            'HTTPS request with different on value' => [
                'https://www.example.org/blog/article.php?id=10&user=foo',
                array_merge($server, ['HTTPS' => '1']),
            ],
            'HTTP request' => [
                'http://www.example.org/blog/article.php?id=10&user=foo',
                array_merge($server, ['HTTPS' => 'off', 'SERVER_PORT' => '80']),
            ],
            'HTTP_HOST missing -> fallback to SERVER_NAME' => [
                'https://www.example.org/blog/article.php?id=10&user=foo',
                array_merge($server, ['HTTP_HOST' => null]),
            ],
            'HTTP_HOST and SERVER_NAME missing -> fallback to SERVER_ADDR' => [
                'https://217.112.82.20/blog/article.php?id=10&user=foo',
                array_merge($server, ['HTTP_HOST' => null, 'SERVER_NAME' => null]),
            ],
            'Query string with ?' => [
                'https://www.example.org/path?continue=https://example.com/path?param=1',
                array_merge($server, ['REQUEST_URI' => '/path?continue=https://example.com/path?param=1', 'QUERY_STRING' => '']),
            ],
            'No query String' => [
                'https://www.example.org/blog/article.php',
                array_merge($server, ['REQUEST_URI' => '/blog/article.php', 'QUERY_STRING' => '']),
            ],
            'Host header with port' => [
                'https://www.example.org:8324/blog/article.php?id=10&user=foo',
                array_merge($server, ['HTTP_HOST' => 'www.example.org:8324']),
            ],
            'IPv6 local loopback address' => [
                'https://[::1]:8000/blog/article.php?id=10&user=foo',
                array_merge($server, ['HTTP_HOST' => '[::1]:8000']),
            ],
            'Invalid host' => [
                'https://localhost/blog/article.php?id=10&user=foo',
                array_merge($server, ['HTTP_HOST' => 'a:b']),
            ],
            'Different port with SERVER_PORT' => [
                'https://www.example.org:8324/blog/article.php?id=10&user=foo',
                array_merge($server, ['SERVER_PORT' => '8324']),
            ],
            'REQUEST_URI missing query string' => [
                'https://www.example.org/blog/article.php?id=10&user=foo',
                array_merge($server, ['REQUEST_URI' => '/blog/article.php']),
            ],
            'Empty server variable' => [
                'http://localhost',
                [],
            ],
        ];
    }

    /**
     * @dataProvider dataGetUriFromGlobals
     */
    public function testGetUriFromGlobals($expected, $serverParams)
    {
        $factory = new Psr17Factory();

        self::assertEquals($factory->createUri($expected), $factory->createUriFromGlobals($serverParams));
    }

    public function testFromGlobals()
    {
        $server = [
            'REQUEST_URI' => '/blog/article.php?id=10&user=foo',
            'SERVER_PORT' => '443',
            'SERVER_ADDR' => '217.112.82.20',
            'SERVER_NAME' => 'www.example.org',
            'SERVER_PROTOCOL' => 'HTTP/1.1',
            'REQUEST_METHOD' => 'POST',
            'QUERY_STRING' => 'id=10&user=foo',
            'DOCUMENT_ROOT' => '/path/to/your/server/root/',
            'CONTENT_TYPE' => 'text/plain',
            'HTTP_HOST' => 'www.example.org',
            'HTTP_ACCEPT' => 'text/html',
            'HTTP_REFERRER' => 'https://example.com',
            'HTTP_USER_AGENT' => 'My User Agent',
            'HTTPS' => 'on',
            'REMOTE_ADDR' => '193.60.168.69',
            'REMOTE_PORT' => '5390',
            'SCRIPT_NAME' => '/blog/article.php',
            'SCRIPT_FILENAME' => '/path/to/your/server/root/blog/article.php',
            'PHP_SELF' => '/blog/article.php',
        ];

        $cookie = [
            'logged-in' => 'yes!'
        ];

        $post = [
            'name' => 'Pesho',
            'email' => 'pesho@example.com',
        ];

        $get = [
            'id' => 10,
            'user' => 'foo',
        ];

        $files = [
            'file' => [
                'name' => 'MyFile.txt',
                'type' => 'text/plain',
                'tmp_name' => __FILE__,
                'error' => UPLOAD_ERR_OK,
                'size' => 123,
            ],
            'files' => [
                'name' => ['file_0' => ['NestedFile.txt']],
                'type' => ['file_0' => ['text/plain']],
                'tmp_name' => ['file_0' => ['/not-exists']],
                'error' => ['file_0' => [UPLOAD_ERR_OK]],
                'size' => ['file_0' => [123]],
            ],
        ];

        $factory = new Psr17Factory();
        $server = $factory->createServerRequestFromGlobals($server, $get, $post, $cookie, $files);

        self::assertSame('POST', $server->getMethod());
        self::assertEquals([
            'Host' => ['www.example.org'],
            'Content-Type' => ['text/plain'],
            'Accept' => ['text/html'],
            'Referrer' => ['https://example.com'],
            'User-Agent' => ['My User Agent'],
        ], $server->getHeaders());
        self::assertSame('', (string) $server->getBody());
        self::assertSame('1.1', $server->getProtocolVersion());
        self::assertSame($cookie, $server->getCookieParams());
        self::assertSame($post, $server->getParsedBody());
        self::assertSame($get, $server->getQueryParams());

        self::assertEquals(
            $factory->createUri('https://www.example.org/blog/article.php?id=10&user=foo'),
            $server->getUri()
        );

        $expectedFiles = [
            'file' => $factory->createUploadedFile(
                $server->getUploadedFiles()['file']->getStream(),
                123,
                UPLOAD_ERR_OK,
                'MyFile.txt',
                'text/plain'
            ),
            'files' => [
                'file_0' => [
                    $factory->createUploadedFile(
                        $server->getUploadedFiles()['files']['file_0'][0]->getStream(),
                        123,
                        UPLOAD_ERR_OK,
                        'NestedFile.txt',
                        'text/plain'
                    ),
                ],
            ],
        ];

        self::assertEquals($expectedFiles, $server->getUploadedFiles());

        self::assertSame('plainfile', $server->getUploadedFiles()['file']->getStream()->getMetadata()['wrapper_type']);
        self::assertSame('PHP', $server->getUploadedFiles()['files']['file_0'][0]->getStream()->getMetadata()['wrapper_type']);
    }
}
