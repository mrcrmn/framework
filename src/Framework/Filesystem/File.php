<?php

namespace Framework\Filesystem;

class File
{
    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    protected function getPath($path)
    {
        if (strpos($path, base_path()) === 0) {
            return $path;
        }
        #
        return base_path($path);
    }

    public function exists($path)
    {
        return file_exists($this->getPath($path));
    }

    public function put($path, $content)
    {
        return file_put_contents($this->getPath($path), $content);
    }

    public function get($path)
    {
        return file_get_contents($this->getPath($path));
    }

    public function lastModified($path)
    {
        return filemtime($this->getPath($path));
    }
}
