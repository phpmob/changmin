<?php

namespace PhpMob\MediaBundle\Imagine;

use Gaufrette\Adapter\DoctrineDbal;
use Gaufrette\FilesystemInterface;
use Liip\ImagineBundle\Binary\Loader\LoaderInterface;

class DbalLoader implements LoaderInterface
{
    /**
     * @var DoctrineDbal|FilesystemInterface
     */
    private $dbal;

    /**
     * DbalLoader constructor.
     *
     * @param FilesystemInterface $dbal
     */
    public function __construct(FilesystemInterface $dbal)
    {
        $this->dbal = $dbal;
    }

    /**
     * {@inheritdoc}
     */
    public function find($path)
    {
        return $this->dbal->read($path);
    }
}
