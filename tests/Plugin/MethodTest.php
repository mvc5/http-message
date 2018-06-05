<?php
/**
 *
 */

namespace Valar\Test\Plugin;

use Mvc5\App;
use PHPUnit\Framework\TestCase;
use Valar\Plugin\Method;
use Valar\ServerRequest;

class MethodTest
    extends TestCase
{
    /**
     *
     */
    function test()
    {
        $plugins = ['method' => new Method];

        $config = new App(['services' => $plugins], null, true, true);

        $request = new ServerRequest($config, new App);
        $config->scope($request);

        $this->assertEquals('GET', $request->getMethod());
    }
}
