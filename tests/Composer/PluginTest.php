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
    public function testMissingRequires(array $expected, InstalledArrayRepository $repo, array $rootRequires, array $rootDevRequires, $pinnedAbstractions = [])
    {
        $plugin = new Plugin();

        $this->assertSame($expected, $plugin->getMissingRequires($repo, [$rootRequires, $rootDevRequires], true, $pinnedAbstractions));
    }

    public static function provideMissingRequires()
    {
        $link = new Link('source', 'target', new Constraint(Constraint::STR_OP_GE, '1'));
        $repo = new InstalledArrayRepository([
            'php-http/discovery' => new Package('php-http/discovery', '1.0.0.0', '1.0'),
        ]);

        yield 'empty' => [[[], [], []], $repo, [], []];

        $rootRequires = [
            'php-http/discovery' => $link,
            'php-http/async-client-implementation' => $link,
            'psr/http-message-implementation' => $link,
        ];
        $expected = [[
            'psr/http-message-implementation' => [],
            'php-http/async-client-implementation' => [
                'symfony/http-client',
            ],
            'psr/http-factory-implementation' => [
                'nyholm/psr7',
            ],
        ], [], []];

        yield 'async-httplug' => [$expected, $repo, $rootRequires, []];

        unset($expected[0]['php-http/async-client-implementation']);

        yield 'pinned' => [$expected, $repo, $rootRequires, [], ['php-http/async-client-implementation' => true]];

        $repo = new InstalledArrayRepository([
            'php-http/discovery' => new Package('php-http/discovery', '1.0.0.0', '1.0'),
            'nyholm/psr7' => new Package('nyholm/psr7', '1.0.0.0', '1.0'),
        ]);
        $repo->setDevPackageNames(['nyholm/psr7']);

        $rootRequires = [
            'php-http/discovery' => $link,
            'psr/http-factory-implementation' => $link,
        ];

        $expected = [[
            'psr/http-factory-implementation' => [
                'nyholm/psr7',
            ],
        ], [], [
            'psr/http-factory-implementation' => [
                'nyholm/psr7',
            ],
        ]];

        yield 'move-to-require' => [$expected, $repo, $rootRequires, []];

        $package = new Package('symfony/symfony', '1.0.0.0', '1.0');
        $package->setReplaces([
            'symfony/http-client' => new Link('symfony/symfony', 'symfony/http-client', new Constraint(Constraint::STR_OP_GE, '1'))
        ]);

        $repo = new InstalledArrayRepository([
            'php-http/discovery' => new Package('php-http/discovery', '1.0.0.0', '1.0'),
            'symfony/symfony' => $package,
        ]);

        $rootRequires = [
            'php-http/discovery' => $link,
            'php-http/async-client-implementation' => $link,
            'symfony/symfony' => $link,
        ];

        $expected = [[
            'php-http/async-client-implementation' => [
                'guzzlehttp/promises',
                'php-http/message-factory',
                'php-http/httplug',
            ],
            'psr/http-factory-implementation' => [
                'nyholm/psr7',
            ],
        ], [], []];

        yield 'replace' => [$expected, $repo, $rootRequires, []];
    }
}
