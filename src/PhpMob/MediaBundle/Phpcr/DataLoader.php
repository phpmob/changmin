<?php

/*
 * This file is part of the PhpMob package.
 *
 * (c) Ishmael Doss <nukboon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PhpMob\MediaBundle\Phpcr;

use League\Flysystem\Phpcr\PhpcrAdapter;
use Liip\ImagineBundle\Binary\Loader\LoaderInterface;

/**
 * @author Ishmael Doss <nukboon@gmail.com>
 */
class DataLoader implements LoaderInterface
{
    /**
     * @var PhpcrAdapter
     */
    private $adapter;

    public function __construct(PhpcrAdapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function find($path)
    {
        if ($result = $this->adapter->read($path)) {
            return $result['contents'];
        }

        return null;
    }
}
