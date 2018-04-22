<?php

namespace Framework\Session;

use Framework\Session\SessionBag;

class Session
{
    /**
     * The Session Data.
     *
     * @var \Framework\Session\SessionBag
     */
    public $session;

    /**
     * The Constructor of the class.
     *
     * @return void
     */
    public function __construct()
    {
        session_start();
        $this->session = new SessionBag();        
        $this->generateCsrfToken();
    }

    protected function generateCsrfToken()
    {
        if (! $this->session->has('_token')) {
            $token = bin2hex(openssl_random_pseudo_bytes(32));

            $this->session->add(
                '_token',
                $token
            );
        }

        return $this->getCsrfToken();
    }

    public function getCsrfToken()
    {
        return $this->session->get('_token', null);
    }

    public function verifyCsrfToken($token)
    {
        return $token === $this->getCsrfToken();
    }

}
