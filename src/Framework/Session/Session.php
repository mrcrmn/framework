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
        $this->start();
        $this->session = new SessionBag();        
    }

    /**
     * Starts the session.
     *
     * @return void
     */
    public function start()
    {
        session_start();
    }

    public function generateCsrfToken()
    {
        if (! $this->session->has('_token')) {
            $token = bin2hex(random_bytes(32));

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
