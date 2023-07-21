<?php

namespace Models\Entities;

class Hotel
{
    public function __construct(public ?int $id, public string $name, public string $imagePath, public string $countryName, public string $cityName, public int $stars, public float $cost, public string $info)
    {
        //empty
    }

    public static function parseFromArray(array $associativeArray): Hotel {
        return new Hotel(id: @$associativeArray['id'] ?? @$associativeArray['Id'], name: @$associativeArray['name'] ?? @$associativeArray['Name'], imagePath: @$associativeArray['imagePath'] ?? @$associativeArray['ImagePath'], countryName: @$associativeArray['countryName'] ?? @$associativeArray['CountryName'], cityName: @$associativeArray['cityName'] ?? @$associativeArray['CityName'], stars: @$associativeArray['stars'] ?? @$associativeArray['Stars'], cost: @$associativeArray['cost'] ?? @$associativeArray['Cost'], info: @$associativeArray['info'] ?? @$associativeArray['Info']);
    }
}