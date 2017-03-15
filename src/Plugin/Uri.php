<?php
/**
 *
 */

namespace Valar\Plugin;

use Mvc5\Plugin\ScopedCall;
use Mvc5\Plugin\Shared;
use Valar\Http\Uri as HttpUri;

class Uri
    extends Shared
{
    /**
     * @param $name
     */
    function __construct($name = 'uri')
    {
        parent::__construct($name, new ScopedCall($this));
    }

    /**
     * @return \Closure
     */
    function __invoke()
    {
        return function() {
            /** @var \Valar\ServerRequest $this */
            return new HttpUri([
                'scheme' => $this->http->getScheme(),
                'host'   => $this->http->getHost(),
                'port'   => $this->http->getPort(),
                'user'   => $this->http->getUser(),
                'pass'   => $this->http->getPassword(),
                'path'   => urldecode($this->http->getPathInfo()),
                'query'  => $this->http->getQueryString(),
            ]);
        };
    }
}
