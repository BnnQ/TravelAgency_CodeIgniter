<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Exceptions\LoginAlreadyTakenException;
use Exceptions\UserNotFoundException;
use Exceptions\ValueInvalidationException;
use Models\ValidationRule;

class Account extends BaseController
{
    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    public function login(): string
    {
        return view('login', ['title' => 'Login']);
    }

    public function submitLogin()
    {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');

        try {
            $userManager = Services::userManager();
            if ($userManager->verifyAndSignInUser($login, $password, $this->response))
                return redirect('Hotel::index')->withCookies();
            else
                $data['errors'][] = "Invalid username or password.";
        } catch (UserNotFoundException) {
            $data['errors'][] = "User with this login does not exist.";
        }

        return redirect('Account::login')->with('errors', $data['errors'])->withCookies();
    }

    public function register(): string
    {
        return view('register', ['title' => 'Register']);
    }

    public function submitRegister() {
        $login = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $email = $this->request->getPost('email');

        $loginPattern = '/^[A-Za-z\d_]{3,27}$/';
        $passwordPattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[A-Za-z\d\W_]{8,27}$/';
        $emailPattern = '/^\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}\b$/';
        $validator = (Services::validatorBuilder())
            ->addRule(new ValidationRule(preg_match($loginPattern, $login), "Login doesnt meet the requirements:\n• Can only contain latin letters, digits, and underscores\n• A length must be at least 3 characters and at most 27 characters"))
            ->addRule(new ValidationRule(preg_match($passwordPattern, $password), "Password doesnt meet the requirements:\n• Must contain at least one lowercase letter\n• Must contain at least one uppercase letter\n• Must contain at least one digit\n• Must contain at least one special character\n• A length must be at least 8 characters and at most 27 characters"))
            ->addRule(new ValidationRule(preg_match($emailPattern, $email), "Entered value is not valid email address"))
            ->build();

        if ($errorMessage = $validator->validateSoft()) {
            $data['errors'][] = $errorMessage;
            return redirect('Account::register')->with('errors', $data['errors']);
        } else {
            try {
                $userManager = Services::userManager();
                $userManager->signUpUser($login, $password, $email);
                $userManager->signInUser($login, $this->response);

                return redirect('Hotel::index')->withCookies();
            } catch (LoginAlreadyTakenException) {
                $data['errors'][] = "Login already taken!";
                return redirect('Account::register')->with('errors', $data['errors'])->withCookies();
            } catch (ValueInvalidationException $exception) {
                $data['errors'][] = $exception->getMessage();
                return redirect('Account::register')->with('errors', $data['errors'])->withCookies();
            }
        }
    }

    public function logout() {
        $userManager = Services::userManager();
        $userManager->signOutUser($this->response);
        return redirect('Account::login')->withCookies();
    }

}