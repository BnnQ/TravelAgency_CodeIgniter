<?php

namespace Services\Abstractions;

use Models\Entities\City;

interface ICityRepository
{
    /**
     * @return City[]
     */
    public function getAll(): array;

    /**
     * @return City[]
     */
    public function getByCountryName(string $countryName): array;

    public function getByName(string $name): City;

    public function add(City $city): void;

    public function delete(int $id): void;
}