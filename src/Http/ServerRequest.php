<?php
/**
 *
 */

namespace Valar\Http;

use Mvc5\Arg;
use Mvc5\Cookie\HttpCookies;
use Mvc5\Http\HttpHeaders;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\PhpInputStream;

use function is_array;
use function strlen;
use function substr;
use function Zend\Diactoros\ {
    marshalHeadersFromSapi,
    marshalUriFromSapi,
    normalizeServer,
    normalizeUploadedFiles,
    parseCookieHeader
};

class ServerRequest
    extends Request
    implements ServerRequestInterface
{
    /**
     *
     */
    use Config\ServerRequest;

    /**
     * @param array $config
     */
    function __construct($config = [])
    {
        !isset($config[Arg::SERVER]) &&
            $config[Arg::SERVER] = normalizeServer($_SERVER);

        $server = $config[Arg::SERVER];

        !isset($config[Arg::HEADERS]) &&
            $config[Arg::HEADERS] = marshalHeadersFromSapi($server);

        is_array($config[Arg::HEADERS]) &&
            $config[Arg::HEADERS] = new HttpHeaders($config[Arg::HEADERS]);

        !isset($config[Arg::URI]) &&
            $config[Arg::URI] = new Uri(marshalUriFromSapi($server, $config[Arg::HEADERS]->all()));

        !isset($config[Arg::COOKIES]) &&
            $config[Arg::COOKIES] = new HttpCookies(isset($config[Arg::HEADERS]['cookie']) ?
                parseCookieHeader($config[Arg::HEADERS]['cookie']) : $_COOKIE);

        is_array($config[Arg::COOKIES]) &&
            $config[Arg::COOKIES] = new HttpCookies($config[Arg::COOKIES]);

        !isset($config[Arg::ARGS]) && $config[Arg::ARGS] = $_GET;
        !isset($config[Arg::ATTRIBUTES]) && $config[Arg::ATTRIBUTES] = [];
        !isset($config[Arg::BODY]) && $config[Arg::BODY] = new PhpInputStream;
        !isset($config[Arg::DATA]) && $config[Arg::DATA] = $_POST;
        !isset($config[Arg::FILES]) && $config[Arg::FILES] = normalizeUploadedFiles($_FILES);
        !isset($config[Arg::METHOD]) && $config[Arg::METHOD] = $server['REQUEST_METHOD'] ?? 'GET';
        !isset($config[Arg::VERSION]) && $config[Arg::VERSION] = substr($server['SERVER_PROTOCOL'] ?? 'HTTP/1.1', strlen('HTTP/'));

        parent::__construct($config);
    }
}
