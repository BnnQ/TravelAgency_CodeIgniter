<?php


use Config\Services;
use Utils\Role;

const ROUTE_Login = "Account/Login";
const ROUTE_Register = "Account/Register";
const ROUTE_Logout = "Account/Logout";
const ROUTE_Admin = "Admin";

const Routes = [
    '/' => 'Hotel',
    ROUTE_Login => 'Login',
    ROUTE_Register => 'Register',
    ROUTE_Logout => 'Logout',
    ROUTE_Admin => 'Admin'
];

function nav_menu(): string
{
    $userManager = Services::userManager();
    $roleManager = Services::roleManager();
    $isUserAuthenticated = $userManager->isCurrentUserAuthenticated();

    helper('url');
    $url = current_url();
    $path = parse_url($url, PHP_URL_PATH);
    $segments = explode('/', trim($path, '/'));
    $currentRoute = implode('/', array_slice($segments, -2));

    $resultBuilder = "<nav class='navbar navbar-expand-lg navbar-light text-light'><div class='container-fluid justify-content-center text-center gap-3' style='padding: 32px'>";

    foreach (Routes as $route => $name) {
        if (($route === ROUTE_Login || $route === ROUTE_Register) && $isUserAuthenticated)
            continue;
        else if ($route === ROUTE_Logout && !$isUserAuthenticated)
            continue;
        else if ($route === ROUTE_Admin && (!$isUserAuthenticated || !$roleManager->isUserInRole($userManager->getCurrentUser(), Role::Admin)))
            continue;

        $className = ($route === $currentRoute) ? "nav-item active" : "nav-item";
        $url = url_to($route);
        $resultBuilder .= anchor($url, $name, ['class' => $className]);
    }

    $resultBuilder .= "</div></nav>";
    return $resultBuilder;
}