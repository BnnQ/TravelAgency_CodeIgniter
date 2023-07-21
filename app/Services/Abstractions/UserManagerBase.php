<?php


namespace Services\Abstractions;

use CodeIgniter\HTTP\ResponseInterface;
use Cookie;
use Exceptions\UserNotFoundException;
use Models\Entities\User;
use Role;

abstract class UserManagerBase
{
    /**
     * @return User[]
     */
    public abstract function getUsers(): array;

    public abstract function getUser(string $login): User;

    public abstract function getUserById(int $id): User;

    public abstract function signUpUser(string $login, string $password, string $email, string $roleName = Role::User, float $discount = 0.0, ?string $avatar = null): void;

    public abstract function verifyAndSignInUser(string $login, string $password, ResponseInterface $response): bool;

    public abstract function signInUser(string $login, ResponseInterface $response): void;

    public abstract function signOutUser(ResponseInterface $response): void;

    public abstract function getCurrentUser(): User;

    public function isCurrentUserAuthenticated(): bool
    {
        try {
            $currentUser = $this->getCurrentUser();
            $token = $_COOKIE[Cookie::AuthenticationToken] ?? null;
            return isset($token) && $token === $currentUser->lastAuthenticationToken;
        } catch (UserNotFoundException $exception) {
            return false;
        }
    }
}