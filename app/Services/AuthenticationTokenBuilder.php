<?php

namespace Services;

use Cookie;
use Exceptions\UnsetuppedBuilderException;

class AuthenticationTokenBuilder
{
    public ?string $login;
    public ?string $token;
    private readonly string $separator;

    public function __construct($separator = '_', string $authenticationToken = null)
    {
        $this->separator = $separator;

        if ($authenticationToken !== null) {
            $splittedAuthenticationToken = explode($separator, $_COOKIE[Cookie::AuthenticationToken]);
            $this->login = $splittedAuthenticationToken[0];
            $this->token = $splittedAuthenticationToken[1];
        }

    }

    public function setLogin(string $login): AuthenticationTokenBuilder {
        $this->login = $login;
        return $this;
    }

    public function setToken(string $token): AuthenticationTokenBuilder {
        $this->token = $token;
        return $this;
    }

    /**
     * @throws UnsetuppedBuilderException
     */
    public function build(): string {
        if ($this->login === null or $this->token === null)
            throw new UnsetuppedBuilderException();

        return $this->login . $this->separator . $this->token;
    }
}