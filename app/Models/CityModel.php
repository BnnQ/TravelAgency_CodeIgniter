<?php

namespace Models;

use CodeIgniter\Model;
use Models\Entities\City;

class CityModel extends Model
{
    protected $table = 'Cities';
    protected $primaryKey = 'Id';
    protected $allowedFields = [
        'Id', 'Name', 'CountryId'
    ];

    public function findAll(int $limit = 0, int $offset = 0)
    {
        $builder = $this->builder($this->table);
        $query = $builder
            ->select('Cities.Id, Cities.Name, Countries.Name as CountryName')
            ->join('Countries', 'Countries.Id = Cities.CountryId');

        $response = $query->get();
        $cities = [];
        foreach ($response->getResultArray() as $cityRow)
            $cities[] = City::parseFromArray($cityRow);

        $response->freeResult();
        return $cities;
    }


    public function findByCountryName(string $countryName): array
    {
        $builder = $this->builder($this->table);
        $query = $builder
            ->select('Cities.*, Countries.Name as CountryName')
            ->join('Countries', 'Cities.CountryId = Countries.Id')
            ->where('Countries.Name', $countryName);

        $response = $query->get();
        $cities = [];
        foreach ($response->getResultArray() as $cityRow)
            $cities[] = City::parseFromArray($cityRow);

        $response->freeResult();
        return $cities;
    }

    public function findByName(string $name): City {
        $builder = $this->builder($this->table);
        $query = $builder
            ->select('Cities.*, Countries.Name as CountryName')
            ->join('Countries', 'Cities.CountryId = Countries.Id')
            ->where('Cities.Name', $name);

        $response = $query->get();
        $city = City::parseFromArray($response->getRowArray());

        $response->freeResult();
        return $city;
    }



}