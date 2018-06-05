<?php
/**
 *
 */

namespace Valar\Test\Plugin;

use Mvc5\App;
use PHPUnit\Framework\TestCase;
use Valar\Plugin\Cookies;
use Valar\ServerRequest;

class CookiesTest
    extends TestCase
{
    /**
     * @throws \Throwable
     */
    function test()
    {
        $GLOBALS['_COOKIE'] = ['foo' => 'bar'];

        $plugins = ['cookies' => new Cookies];

        $config = new App(['services' => $plugins], null, true, true);

        $request = new ServerRequest($config);
        $config->scope($request);

        $this->assertEquals(['foo' => 'bar'], $request->getCookieParams());
    }
}
