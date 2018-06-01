<?php

namespace Framework\Filesystem;

use Framework\Support\ParameterBag;


class UploadedFile
{
    /**
     * The raw uploaded file.
     *
     * @var \Framework\Support\ParameterBag
     */
    protected $file;

    /**
     * Makes a new parameter bag of the uploaded file.
     *
     * @param array $file
     */
    public function __construct($file)
    {
        $this->file = new ParameterBag($file);
    }

    /**
     * Gets the uploaded files name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->file->get('name');
    }

    /**
     * Gets the path to the temp location.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->file->get('tmp_name');
    }

    /**
     * Gets the uploaded files size.
     *
     * @return int
     */
    public function getSize()
    {
        return $this->file->get('size');
    }

    /**
     * Stores the uploaded file at the specified location.
     *
     * @param string $path
     * @return bool
     */
    public function store($destination)
    {
        return fs()->copy($this->getPath(), $destination);
    }
}
