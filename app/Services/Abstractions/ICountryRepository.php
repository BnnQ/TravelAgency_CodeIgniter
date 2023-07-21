<?php

namespace Services\Abstractions;

use Models\Entities\Country;

interface ICountryRepository
{
    /**
     * @return Country[]
     */
    public function getAll(): array;

    public function getByName(string $name): Country;

    public function add(Country $country): void;

    public function delete(int $id): void;
}