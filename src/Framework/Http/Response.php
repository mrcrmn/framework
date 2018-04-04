<?php

namespace Framework\Http;

class Response
{
    /**
     * The Response content.
     *
     * @var string
     */
    protected $content;

    /**
     * The Constructor of the class.
     *
     * @param string $content The Response content.
     * 
     * @return void
     */
    public function __construct($content = "")
    {
        $this->content = $content;
    }

    public function send()
    {
        echo $this->content;
    }
}