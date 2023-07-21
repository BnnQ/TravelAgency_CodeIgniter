<?php

use CodeIgniter\HTTP\ResponseInterface;

class CookieUtils
{
    public static function unsetCookie(string $cookieName, ResponseInterface $response) : void {
        $response->setCookie($cookieName, "", -1);
    }
}