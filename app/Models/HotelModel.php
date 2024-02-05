<?php

namespace Models;

use CodeIgniter\Model;
use Models\Entities\Hotel;

class HotelModel extends Model
{
    protected $table = 'Hotels';
    protected $primaryKey = 'Id';
    protected $allowedFields = [
        'Name', 'CountryId', 'CityId', 'Stars', 'Cost', 'Info'
    ];

    public function findAll(int $limit = 0, int $offset = 0)
    {
        $builder = $this->builder($this->table);
        $query = $builder
            ->select('Hotels.Id, Hotels.Name, Hotels.Stars, Hotels.Cost, Hotels.Info, Images.ImagePath, Countries.Name as CountryName, Cities.Name as CityName')
            ->join('Countries', 'Hotels.CountryId = Countries.Id')
            ->join('Cities', 'Hotels.CityId = Cities.Id') // Adjusted join condition
            ->join('Images', 'Images.HotelId = Hotels.Id');

        if ($limit > 0)
            $query = $query->limit($limit);
        if ($offset > 0)
            $query = $query->offset($offset);

        $response = $query->get();
        $hotels = [];
        foreach ($response->getResultArray() as $hotelRow)
            $hotels[] = Hotel::parseFromArray($hotelRow);

        $response->freeResult();
        return $hotels;
    }

    public function findByName(string $name): Hotel
    {
        $builder = $this->builder($this->table);

        $query = $builder
            ->select('Hotels.Id, Hotels.Name, Hotels.Stars, Hotels.Cost, Hotels.Info, Images.ImagePath, Countries.Name as CountryName, Cities.Name as CityName')
            ->join('Countries', 'Hotels.CountryId = Countries.Id')
            ->join('Cities', 'Hotels.CityId = Cities.Id') // Adjusted join condition
            ->join('Images', 'Images.HotelId = Hotels.Id')
            ->where('Hotels.Name', $name);

        $response = $query->get();
        $hotel = Hotel::parseFromArray($response->getRowArray());

        $response->freeResult();
        return $hotel;
    }
}