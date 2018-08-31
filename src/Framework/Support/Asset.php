<?php

namespace Framework\Support;

class Asset
{
    /**
     * The internal path to the resource.
     *
     * @var string
     */
    protected $path;

    /**
     * The base url.
     * 
     * @var string
     */
    protected $url;

    /**
     * The Constructor of the class
     *
     * @return void
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function makeAssetPath($path)
    {
        if (request()->isSubDir()) {
            $path = str_replace('index.php', 'public/', request()->server('SCRIPT_NAME')) . $path;
        }

        return ltrim($path, '/');
    }

    /**
     * Appends the version hash.
     *
     * @param string $asset
     * @param bool $version
     * @return void
     */
    protected function makeVersion($asset, $version)
    {
        if (! $version) {
            return;
        }

        return '?v=' . filemtime($asset);
    }

    /**
     * Gets an asset path.
     *
     * @param string $asset
     * @param bool $version
     * @return void
     */
    public function get($asset, $version = false)
    {
        if (empty($this->url)) {
            $this->url = app('request')->urlBase();
        }
        
        $path = $this->path . $asset;

        if (! file_exists($path)) {
            return;
        }

        return $this->url . '/' . $this->makeAssetPath($asset) . $this->makeVersion($path, $version);
    }
}
