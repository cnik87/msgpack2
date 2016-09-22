<?php

/*
 * This file is part of the rybakit/msgpack.php package.
 *
 * (c) Eugene Leonovich <gen.work@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MessagePack\Exception;

class InsufficientDataException extends UnpackingFailedException
{
    public function __construct($expectedLength, $actualLength, $code = null, \Exception $previous = null)
    {
        $message = "Not enough data to unpack: expected $expectedLength, got $actualLength.";

        parent::__construct($message, $code, $previous);
    }
}
