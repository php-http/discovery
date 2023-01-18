<?php

namespace tests\Http\Discovery\Composer;

use Composer\Package\Link;
use Composer\Package\Package;
use Composer\Repository\InstalledArrayRepository;
use Composer\Semver\Constraint\Constraint;
use Http\Discovery\Composer\Plugin;
use PHPUnit\Framework\TestCase;

/**
 * @group NothingInstalled
 */
class PluginTest extends TestCase
{
    /**
     * @dataProvider provideMissingRequires
     */
    public function testMissingRequires(array $expected, InstalledArrayRepository $repo, array $rootRequires, array $rootDevRequires)
    {
        $plugin = new Plugin();

        $this->assertSame($expected, $plugin->getMissingRequires($repo, [$rootRequires, $rootDevRequires], true));
    }

    public static function provideMissingRequires()
    {
        $link = new Link('source', 'target', new Constraint(Constraint::STR_OP_GE, '1'));
        $repo = new InstalledArrayRepository([]);

        yield 'empty' => [[[], [], []], $repo, [], []];

        $rootRequires = [
            'php-http/discovery' => $link,
            'php-http/async-client-implementation' => $link,
        ];
        $expected = [[
            'php-http/async-client-implementation' => [
                'symfony/http-client',
                'guzzlehttp/promises',
                'php-http/message-factory',
            ],
            'psr/http-factory-implementation' => [
                'nyholm/psr7',
            ],
        ], [], []];

        yield 'async-httplug' => [$expected, $repo, $rootRequires, []];

        $repo = new InstalledArrayRepository([
            'nyholm/psr7' => new Package('nyholm/psr7', '1.0.0.0', '1.0'),
        ]);
        $repo->setDevPackageNames(['nyholm/psr7']);

        $expected[2] = [
            'psr/http-factory-implementation' => [
                'nyholm/psr7',
            ],
        ];

        yield 'move-to-require' => [$expected, $repo, $rootRequires, []];
    }
}
