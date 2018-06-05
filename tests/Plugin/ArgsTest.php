<?php
/**
 *
 */

namespace Valar\Test\Plugin;

use Mvc5\App;
use PHPUnit\Framework\TestCase;
use Valar\Plugin\Args;
use Valar\ServerRequest;

class ArgsTest
    extends TestCase
{
    /**
     * @throws \Throwable
     */
    function test()
    {
        $GLOBALS['_GET'] = ['foo' => 'bar'];

        $plugins = ['args' => new Args];

        $config = new App(['services' => $plugins], null, true, true);

        $request = new ServerRequest($config);
        $config->scope($request);

        $this->assertEquals(['foo' => 'bar'], $request->args());
    }
}
