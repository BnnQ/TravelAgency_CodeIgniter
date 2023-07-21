<?php

namespace Services;

use Models\CityModel;
use Models\Entities\City;
use Services\Abstractions\ICityRepository;

class DatabaseCityRepository implements ICityRepository
{
    private readonly CityModel $context;
    public function __construct()
    {
        $this->context = model('Models\CityModel');
    }

    public function getAll(): array
    {
        return $this->context->findAll();
    }

    public function getByName(string $name): City
    {
        return $this->context->findByName($name);
    }

    public function getByCountryName(string $countryName): array
    {
        return $this->context->findByCountryName($countryName);
    }

    public function add(City $city): void
    {
        $countryModel = model('Models\CountryModel');
        $countryId = $countryModel->findByName($city->countryName)->id;

        $this->context->insert(['Name' => $city->name, 'CountryId' => $countryId]);
    }

    public function delete(int $id): void
    {
        $this->context->delete($id);
    }

}