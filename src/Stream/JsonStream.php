<?php
/**
 *
 */

namespace Valar\Stream;

use Zend\Diactoros\Stream;

class JsonStream
    extends Stream
{
    /**
     * @param $data
     */
    function __construct($data)
    {
        parent::__construct('php://memory', 'wb+');
        $this->write($this->encode($data));
        $this->rewind();
    }

    /**
     * @param $data
     * @return string
     */
    static function encode($data)
    {
        return json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT | JSON_UNESCAPED_SLASHES);
    }
}