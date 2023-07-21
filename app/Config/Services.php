<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use Services\AuthenticationTokenBuilder;
use Services\DatabaseCityRepository;
use Services\DatabaseCountryRepository;
use Services\DatabaseHotelRepository;
use Services\DatabaseImageRepository;
use Services\DatabaseRoleManager;
use Services\DatabaseUserManager;
use Services\PseudoRandomTokenGenerator;
use Services\ValidatorBuilder;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    public static function tokenGenerator($getShared = false) {
        if ($getShared) {
            return static::getSharedInstance('tokenGenerator');
        }

        return new PseudoRandomTokenGenerator();
    }

    public static function authenticationTokenBuilder($getShared = false, string $authenticationToken = null) {
        if ($getShared) {
            return static::getSharedInstance('authenticationTokenBuilder', $authenticationToken);
        }

        return new AuthenticationTokenBuilder(separator: '_', authenticationToken: $authenticationToken);
    }

    public static function validatorBuilder($getShared = false) {
        if ($getShared) {
            return static::getSharedInstance('validatorBuilder');
        }

        return new ValidatorBuilder();
    }

    public static function userManager($getShared = true) {
        if ($getShared) {
            return static::getSharedInstance('userManager');
        }

        return new DatabaseUserManager();
    }

    public static function roleManager($getShared = true) {
        if ($getShared) {
            return static::getSharedInstance('roleManager');
        }

        return new DatabaseRoleManager();
    }

    public static function countryRepository($getShared = true) {
        if ($getShared) {
            return static::getSharedInstance('countryRepository');
        }

        return new DatabaseCountryRepository();
    }

    public static function cityRepository($getShared = true) {
        if ($getShared) {
            return static::getSharedInstance('cityRepository');
        }

        return new DatabaseCityRepository();
    }

    public static function imageRepository($getShared = true) {
        if ($getShared) {
            return static::getSharedInstance('imageRepository');
        }

        return new DatabaseImageRepository();
    }

    public static function hotelRepository($getShared = true) {
        if ($getShared) {
            return static::getSharedInstance('hotelRepository');
        }

        return new DatabaseHotelRepository();
    }

}