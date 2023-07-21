<?php

namespace Config;

use CodeIgniter\Config\AutoloadConfig;

/**
 * -------------------------------------------------------------------
 * AUTOLOADER CONFIGURATION
 * -------------------------------------------------------------------
 *
 * This file defines the namespaces and class maps so the Autoloader
 * can find the files as needed.
 *
 * NOTE: If you use an identical key in $psr4 or $classmap, then
 * the values in this file will overwrite the framework's values.
 */
class Autoload extends AutoloadConfig
{
    /**
     * -------------------------------------------------------------------
     * Namespaces
     * -------------------------------------------------------------------
     * This maps the locations of any namespaces in your application to
     * their location on the file system. These are used by the autoloader
     * to locate files the first time they have been instantiated.
     *
     * The '/app' and '/system' directories are already mapped for you.
     * you may change the name of the 'App' namespace if you wish,
     * but this should be done prior to creating any namespaced classes,
     * else you will need to modify all of those classes for this to work.
     *
     * Prototype:
     *   $psr4 = [
     *       'CodeIgniter' => SYSTEMPATH,
     *       'App'         => APPPATH
     *   ];
     *
     * @var array<string, array<int, string>|string>
     * @phpstan-var array<string, string|list<string>>
     */
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'      => APPPATH . 'Config',
        'Services' => APPPATH . 'Services',
        'Services/Abstractions' => APPPATH . 'Services/Abstractions',
        'Exceptions' => APPPATH . 'Exceptions',
        'Models' => APPPATH . 'Models',
        'Models/Entities' => APPPATH . 'Models/Entities',
        'Utils' => APPPATH . 'Utils'
    ];

    /**
     * -------------------------------------------------------------------
     * Class Map
     * -------------------------------------------------------------------
     * The class map provides a map of class names and their exact
     * location on the drive. Classes loaded in this manner will have
     * slightly faster performance because they will not have to be
     * searched for within one or more directories as they would if they
     * were being autoloaded through a namespace.
     *
     * Prototype:
     *   $classmap = [
     *       'MyClass'   => '/path/to/class/file.php'
     *   ];
     *
     * @var array<string, string>
     */
    public $classmap = [
        'ICityRepository' => APPPATH . 'Services/Abstractions/ICityRepository.php',
        'ICountryRepository' => APPPATH . 'Services/Abstractions/ICountryRepository.php',
        'IHotelRepository' => APPPATH . 'Services/Abstractions/IHotelRepository.php',
        'IImageRepository' => APPPATH . 'Services/Abstractions/IImageRepository.php',
        'IRoleManager' => APPPATH . 'Services/Abstractions/IRoleManager.php',
        'UserManagerBase' => APPPATH . 'Services/Abstractions/UserManagerBase.php',
        'DatabaseCityRepository' => APPPATH . 'Services/DatabaseCityRepository.php',
        'DatabaseCountryRepository' => APPPATH . 'Services/DatabaseCountryRepository.php',
        'DatabaseHotelRepository' => APPPATH . 'Services/DatabaseHotelRepository.php',
        'DatabaseImageRepository' => APPPATH . 'Services/DatabaseImageRepository.php',
        'DatabaseRoleManager' => APPPATH . 'Services/DatabaseRoleManager.php',
        'DatabaseUserManager' => APPPATH . 'Services/DatabaseUserManager.php',
        'PseudoRandomTokenGenerator' => APPPATH . 'Services/PseudoRandomTokenGenerator.php',
        'Validator' => APPPATH . 'Services/Validator.php',
        'ValidatorBuilder' => APPPATH . 'Services/ValidatorBuilder.php',
        'Cookie' => APPPATH . 'Utils/Cookie.php',
        'CookieUtils' => APPPATH . 'Utils/CookieUtils.php',
        'IoUtils' => APPPATH . 'Utils/IoUtils.php'
    ];

    /**
     * -------------------------------------------------------------------
     * Files
     * -------------------------------------------------------------------
     * The files array provides a list of paths to __non-class__ files
     * that will be autoloaded. This can be useful for bootstrap operations
     * or for loading functions.
     *
     * Prototype:
     *   $files = [
     *       '/path/to/my/file.php',
     *   ];
     *
     * @var string[]
     * @phpstan-var list<string>
     */
    public $files = [];

    /**
     * -------------------------------------------------------------------
     * Helpers
     * -------------------------------------------------------------------
     * Prototype:
     *   $helpers = [
     *       'form',
     *   ];
     *
     * @var string[]
     * @phpstan-var list<string>
     */
    public $helpers = [];
}
