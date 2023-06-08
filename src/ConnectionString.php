<?php

namespace Ramm\RabbitmqClient;

class ConnectionString
{
    /** @var string */
    private $user = '';

    /** @var string */
    private $password = '';

    /** @var string */
    private $host;

    /** @var int */
    private $port = 5672;

    /**
     * @param string $host
     */
    public function __construct($host)
    {
        $this->host = $host;
    }

    /**
     * @param string $host
     * Set the value of uerr
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of user
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the value of password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param string $password
     * @return  self
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of port
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the value of port
     *
     * @param int $port
     * @return  self
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get the value of host
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the value of host
     *
     * @param string $host
     * @return self
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }
}
