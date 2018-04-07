<?php

namespace Framework\Http;

use Framework\Support\ParameterBag;

class Response
{
    /**
     * The Response content.
     *
     * @var string
     */
    protected $content;

    /**
     * The header bag.
     *
     * @var \Framework\Support\ParameterBag
     */
    protected $headers;

    /**
     * The Constructor of the class.
     *
     * @param string $content The Response content.
     * 
     * @return void
     */
    public function __construct($content = "")
    {
        $this->headers = new ParameterBag();
        $this->setContent($content);
    }

    public function setContent($content) {
        
        if (is_array($content)) {
            $this->content = json_encode($content);
            $this->setResponseType('application/json');
        } else {
            $this->content = $content;
            $this->setResponseType('text/html');            
        }

    }

    public function setResponseType($type) {
        $this->headers->add('Content-Type', $type);
    }

    protected function setHeaders()
    {
        foreach ($this->headers->all() as $header => $value) {
            header($header.": ". $value);
        }
    }

    public function send()
    {
        $this->setHeaders();
        echo $this->content;
    }
}