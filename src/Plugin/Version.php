<?php
/**
 *
 */

namespace Valar\Plugin;

use Mvc5\Plugin\ScopedCall;
use Mvc5\Plugin\Shared;

class Version
    extends Shared
{
    /**
     * @param $name
     */
    function __construct($name = 'version')
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
            return substr($this->http->server->get('SERVER_PROTOCOL'), strlen('HTTP/'));
        };
    }
}