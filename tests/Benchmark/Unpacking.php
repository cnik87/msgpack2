<?php

/*
 * This file is part of the rybakit/msgpack.php package.
 *
 * (c) Eugene Leonovich <gen.work@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace MessagePack\Tests\Benchmark;

use MessagePack\Unpacker;

class Unpacking implements Benchmark
{
    private $size;
    private $unpacker;

    public function __construct($size, Unpacker $unpacker = null)
    {
        $this->size = $size;
        $this->unpacker = new Unpacker();
    }

    /**
     * {@inheritdoc}
     */
    public function getTitle()
    {
        return get_class($this->unpacker);
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * {@inheritdoc}
     */
    public function measure($raw, $packed)
    {
        $totalTime = 0;

        for ($i = $this->size; $i; $i--) {
            $this->unpacker->flush()->append($packed);

            $time = microtime(true);
            $this->unpacker->unpack();
            $totalTime += microtime(true) - $time;
        }

        return $totalTime;
    }
}
