<?php

namespace Services;

use Models\Entities\Hotel;
use Models\HotelModel;
use Services\Abstractions\IHotelRepository;

class DatabaseHotelRepository implements IHotelRepository
{
    private readonly HotelModel $context;
    public function __construct()
    {
        $this->context = model('Models\HotelModel');
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->context->findAll();
    }

    public function getByName(string $name): Hotel
    {
        return $this->context->findByName($name);
    }

    public function add(Hotel $hotel): void
    {
        $countryModel = model('Models\CountryModel');
        $cityModel = model('Models\CityModel');

        $countryId = $countryModel->findByName($hotel->countryName)->id;
        $cityId = $cityModel->findByName($hotel->cityName)->id;

        $this->context->insert(['Name' => $hotel->name, 'CountryId' => $countryId, 'CityId' => $cityId, 'Stars' => $hotel->stars, 'Cost' => $hotel->cost, 'Info' => $hotel->info]);
    }

    public function delete(int $id): void
    {
        $this->context->delete($id);
    }

}