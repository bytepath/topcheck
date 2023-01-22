<?php

namespace Potatoquality\TopCheck\Containers;

use Carbon\Carbon;

/**
 * Represents an auth
 */
class AuthToken
{
    /**
     * @var null
     */
    protected $token = null;

    /**
     * @var null
     */
    protected $expiresAt = null;

    public function __construct($token, $expiresInSeconds)
    {
        $this->token = $token;
        $this->expires = Carbon::now()->addSeconds($expiresInSeconds);
    }

    /**
     * Returns the auth token
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * Returns the expiry time of the token
     */
    public function getExpiresAt(): Carbon
    {
        return $this->expires;
    }
}
