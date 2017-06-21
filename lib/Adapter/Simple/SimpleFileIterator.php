<?php

namespace DTL\Filesystem\Adapter\Simple;

use DTL\Filesystem\Domain\FileList;
use DTL\Filesystem\Domain\FilePath;

class SimpleFileIterator implements \IteratorAggregate
{
    private $path;

    public function __construct(FilePath $path)
    {
        $this->path = $path;
    }

    public function getIterator()
    {
        $files = new \RecursiveDirectoryIterator($this->path->__toString());
        $files = new \RecursiveIteratorIterator($files);

        foreach ($files as $file) {
            if (false === $file->isFile()) {
                continue;
            }

            $path = FilePath::fromString((string) $file);
            yield $this->path->relativize($path);
        }
    }
}
