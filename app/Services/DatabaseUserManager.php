<?php

namespace Services;

use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;
use Cookie;
use CookieUtils;
use Exceptions\LoginAlreadyTakenException;
use Exceptions\UserNotFoundException;
use Models\Entities\User;
use Models\UserModel;
use ReflectionException;
use Services\Abstractions\ITokenGenerator;
use Services\Abstractions\UserManagerBase;
use Utils\Role;

class DatabaseUserManager extends UserManagerBase
{
    private readonly UserModel $context;
    private readonly ITokenGenerator $tokenGenerator;
    public function __construct()
    {
        $this->context = model('Models\UserModel');
        $this->tokenGenerator = Services::tokenGenerator();
    }

    /**
     * @inheritDoc
     */
    public function getUsers(): array
    {
        return $this->context->findAll();
    }

    /**
     * @throws UserNotFoundException
     */
    public function getUser(string $login): User
    {
        $user = $this->context->findByLogin($login);
        if ($user === null)
            throw new UserNotFoundException();

        return $user;
    }

    /**
     * @throws UserNotFoundException
     */
    public function getUserById(int $id): User
    {
        $userRow = $this->context->find($id);

        return $userRow !== null ? User::parseFromArray($userRow) : throw new UserNotFoundException();
    }

    /**
     * @throws LoginAlreadyTakenException
     * @throws ReflectionException
     */
    public function signUpUser(string $login, string $password, string $email, string $roleName = Role::User, float $discount = 0.0, ?string $avatar = null): void
    {
        $user = $this->context->findByLogin($login);

        if ($user !== null)
            throw new LoginAlreadyTakenException();

        $roleId = Services::roleManager()->getRoleByName($roleName)->id;
        #region Registering user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $this->context->insert(['Login' => $login, 'HashedPassword' => $hashedPassword, 'Email' => $email, 'RoleId' => $roleId, 'Discount' => $discount, 'Avatar' => $avatar]);
        #endregion
    }

    public function signInUser(string $login, ResponseInterface $response): void
    {
        #region Setting cookie
        $authenticationToken = Services::authenticationTokenBuilder()
            ->setLogin($login)
            ->setToken($this->tokenGenerator->generateToken(length: 9))
            ->build();

        $secondsInMinute = 60;
        $minutesInHour = 60;
        $expiresTime = ($secondsInMinute * $minutesInHour * 3);

        $response->setCookie(Cookie::AuthenticationToken, $authenticationToken, $expiresTime);
        #endregion

        #region Updating value in database
        $this->context->updateAuthenticationTokenByLogin($login, $authenticationToken);
        #endregion
    }

    /**
     * @param string $login
     * @param string $password
     * @param ResponseInterface $response
     * @throws UserNotFoundException
     */
    public function verifyAndSignInUser(string $login, string $password, ResponseInterface $response): bool
    {
        $user = $this->getUser($login);
        if (password_verify($password, $user->hashedPassword)) {
            $this->signInUser($login, $response);
            return true;
        }

        return false;
    }

    public function signOutUser(ResponseInterface $response): void
    {
        CookieUtils::unsetCookie(Cookie::AuthenticationToken, $response);
    }

    /**
     * @throws UserNotFoundException
     */
    public function getCurrentUser(): User
    {
        $authenticationToken = $_COOKIE[Cookie::AuthenticationToken] ?? null;
        if (!isset($authenticationToken))
            throw new UserNotFoundException();

        $login = Services::authenticationTokenBuilder(authenticationToken: $authenticationToken)->login;
        return $this->getUser($login);
    }


}