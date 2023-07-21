<?php

namespace Services;

use Models\CountryModel;
use Models\Entities\Country;
use Services\Abstractions\ICountryRepository;

class DatabaseCountryRepository implements ICountryRepository
{
    private readonly CountryModel $context;
    public function __construct()
    {
        $this->context = model('Models\CountryModel');
    }

    public function getAll(): array
    {
        return $this->context->findAll();
    }

    public function getByName(string $name): Country
    {
        return $this->context->findByName($name);
    }

    public function add(Country $country): void
    {
        $this->context->insert(['Name' => $country->name]);
    }

    public function delete(int $id): void
    {
        $this->context->delete($id);
    }

}