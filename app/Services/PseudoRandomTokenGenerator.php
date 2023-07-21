<?php

namespace Services;

use Services\Abstractions\ITokenGenerator;

class PseudoRandomTokenGenerator implements ITokenGenerator
{
    public function generateToken(int $length): string
    {
        $token = openssl_random_pseudo_bytes($length);
        return bin2hex($token);
    }
}