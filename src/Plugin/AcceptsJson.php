<?php
/**
 *
 */

namespace Valar\Plugin;

use Mvc5\Plugin\ScopedCall;
use Mvc5\Plugin\Shared;
use Symfony\Component\HttpFoundation\AcceptHeader;

use function array_keys;
use function strpos;

use const Mvc5\HEADERS;

final class AcceptsJson
    extends Shared
{
    /**
     * @param string $name
     */
    function __construct(string $name = 'accepts_json')
    {
        parent::__construct($name, new ScopedCall($this));
    }

    /**
     * @param string|null $accept
     * @return string|null
     */
    static function header(?string $accept) : ?string
    {
        return null !== $accept ? (array_keys(AcceptHeader::fromString($accept)->all())[0] ?? null) : null;
    }

    /**
     * @param null|string $accept
     * @return bool
     */
    static function match(?string $accept) : bool
    {
        return $accept && (false !== strpos($accept, '/json') || false !== strpos($accept, '+json'));
    }

    /**
     * @return \Closure
     */
    function __invoke() : \Closure
    {
        return fn() => AcceptsJson::match(AcceptsJson::header($this[HEADERS]['accept']));
    }
}
