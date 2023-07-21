<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;
use Config\Services;
use Exceptions\LoginAlreadyTakenException;
use Exceptions\ValueInvalidationException;
use Models\Entities\City;
use Models\Entities\Country;
use Models\Entities\Hotel;
use Models\ImageDto;
use Utils\Role;
use Services\Abstractions\ICityRepository;
use Services\Abstractions\ICountryRepository;
use Services\Abstractions\IHotelRepository;
use Services\Abstractions\IImageRepository;
use Services\Abstractions\IRoleManager;
use Services\Abstractions\UserManagerBase;

class Admin extends BaseController
{
    private readonly ICountryRepository $countryRepository;
    private readonly ICityRepository $cityRepository;
    private readonly IHotelRepository $hotelRepository;
    private readonly IImageRepository $imageRepository;
    private readonly UserManagerBase $userManager;
    private readonly IRoleManager $roleManager;

    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $this->countryRepository = Services::countryRepository();
        $this->cityRepository = Services::cityRepository();
        $this->hotelRepository = Services::hotelRepository();
        $this->imageRepository = Services::imageRepository();
        $this->userManager = Services::userManager();
        $this->roleManager = Services::roleManager();
    }

    public function index() {
        if (!$this->userManager->isCurrentUserAuthenticated() || !$this->roleManager->isUserInRole($this->userManager->getCurrentUser(), Role::Admin))
            return redirect('Account::login');

        return view('admin', ['countries' => $this->countryRepository->getAll(), 'cities' => $this->cityRepository->getAll(), 'hotels' => $this->hotelRepository->getAll(), 'images' => $this->imageRepository->getAll(), 'users' => $this->userManager->getUsers()]);
    }

    public function getCities() {
        $cities = $this->cityRepository->getByCountryName($this->request->getPost('country'));

        $response = [
            'cities' => $cities
        ];

        return $this->response->setJSON($response);
    }

    public function addCountry(): RedirectResponse
    {
        $country = Country::parseFromArray($this->request->getPost());
        $this->countryRepository->add($country);

        return redirect('Admin::index');
    }

    public function deleteCountry(): RedirectResponse
    {
        $countries = $this->request->getPost('countries');
        if ($countries) {
            foreach ($countries as $countryId) {
                $this->countryRepository->delete($countryId);
            }
        } else {
            $data['errors'][] = 'Select at least one country.';
        }

        $redirect = redirect('Admin::index');
        if (isset($data['errors']))
            $redirect = $redirect->with('errors', $data['errors']);

        return $redirect;
    }

    public function addCity(): RedirectResponse
    {
        $city = City::parseFromArray($this->request->getPost());
        $this->cityRepository->add($city);

        return redirect('Admin::index');
    }

    public function deleteCity(): RedirectResponse
    {
        $cities = $this->request->getPost('cities');
        if ($cities) {
            foreach ($cities as $countryId) {
                $this->cityRepository->delete($countryId);
            }
        } else {
            $data['errors'][] = 'Select at least one city.';
        }

        return redirect('Admin::index')->with('errors', $data['errors']);
    }

    public function addHotel(): RedirectResponse
    {
        $hotel = Hotel::parseFromArray($this->request->getPost());
        $this->hotelRepository->add($hotel);

        return redirect('Admin::index');
    }

    public function deleteHotel(): RedirectResponse
    {
        $hotels = $this->request->getPost('hotels');
        if ($hotels) {
            foreach ($hotels as $countryId) {
                $this->hotelRepository->delete($countryId);
            }
        } else {
            $data['errors'][] = 'Select at least one hotel.';
        }

        $redirect = redirect('Admin::index');
        if (isset($data['errors']))
            $redirect = $redirect->with('errors', $data['errors']);

        return $redirect;
    }

    public function addUser() {
        $avatarBytes = null;
        if ($this->request->getFile('avatar') && $this->request->getFile('avatar')->getError() === UPLOAD_ERR_OK) {
            $avatarFileName = $this->request->getFile('avatar')->getTempName();
            $avatarBytes = file_get_contents($avatarFileName);
        }

        try {
            $this->userManager->signUpUser(login: $this->request->getPost('login'), password: $this->request->getPost('password'), email: $this->request->getPost('email'), roleName: $this->request->getPost('roleName'), discount: $this->request->getPost('discount'), avatar: $avatarBytes);
        } catch (LoginAlreadyTakenException) {
            $data['errors'][] = "Login already taken!";
        } catch (ValueInvalidationException $exception) {
            $data['errors'][] = $exception->getMessage();
        }

        $redirect = redirect('Admin::index');
        if (isset($data['errors']))
            $redirect = $redirect->with('errors', $data['errors']);

        return $redirect;
    }

    public function addImage()
    {
        $hotelName = $this->request->getPost('hotelName');

        $images = $this->request->getFileMultiple('images');
        foreach ($images as $image)
        {
            if ($image->isValid() && !$image->hasMoved())
            {
                $uploadedImage = new ImageDto();
                $uploadedImage->hotelName = $hotelName;

                $uploadedImage->uploadedFile = [
                    'tmp_name' => $image->getTempName()
                ];

                $this->imageRepository->add($uploadedImage);
            }
        }

        return redirect('Admin::index');
    }

    public function deleteImage(): RedirectResponse
    {
        $images = $this->request->getPost('images');
        if ($images) {
            foreach ($images as $imageId) {
                $this->imageRepository->delete($imageId);
            }
        } else {
            $data['errors'][] = 'Select at least one image.';
        }

        $redirect = redirect('Admin::index');
        if (isset($data['errors']))
            $redirect = $redirect->with('errors', $data['errors']);

        return $redirect;
    }

}