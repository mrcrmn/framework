<?php

namespace Framework\Filesystem;

class File
{
    /**
     * Gets the path to a file.
     *
     * @param string $path
     * @return string
     */
    protected function getPath($path)
    {
        if (strpos($path, base_path()) === 0) {
            return $path;
        }
        
        return base_path($path);
    }

    /**
     * Checks if the file exists.
     *
     * @param string $path
     * @return bool
     */
    public function exists($path)
    {
        return file_exists($this->getPath($path));
    }

    /**
     * Writes a new file.
     *
     * @param string $path
     * @param string $content
     * @return void
     */
    public function put($path, $content)
    {
        return file_put_contents($this->getPath($path), $content);
    }

    /**
     * Gets the content of a file.
     *
     * @param string $path
     * @return string
     */
    public function get($path)
    {
        return file_get_contents($this->getPath($path));
    }

    /**
     * Gets the last modified timestamp of a file.
     *
     * @param string $path
     * @return int
     */
    public function lastModified($path)
    {
        return filemtime($this->getPath($path));
    }
}
