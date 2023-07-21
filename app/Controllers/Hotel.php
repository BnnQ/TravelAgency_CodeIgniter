<?php

namespace App\Controllers;

class Hotel extends BaseController
{
    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }

    public function index() {
        $cityName = $this->request->getGet('city');
        $stars = $this->request->getGet('stars');

        $cities = model('Models\CityModel')
            ->join('Hotels', 'Hotels.CityId = Cities.Id')
            ->select('Hotels.*')
            ->findAll();

        $starsList = [1, 2, 3, 4, 5];

        $hotelModel = model('Models\HotelModel');
        if (!empty($cityName)) {
            $cityId = model('Models\CityModel')->findByName($cityName)->id;
            $hotelModel->where('CityId', $cityId);
        }
        if (!empty($stars)) {
            $hotelModel->where('Stars', $stars);
        }

        $hotels = $hotelModel->findAll();
        return view('hotelList', ['cities' => $cities, 'stars' => $starsList, 'hotels' => $hotels]);
    }
}