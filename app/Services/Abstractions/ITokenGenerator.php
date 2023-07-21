<?php

namespace Services\Abstractions;

interface ITokenGenerator
{
    public function generateToken(int $length): string;
}