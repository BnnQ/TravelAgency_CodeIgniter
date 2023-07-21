<?php

namespace Models;

use CodeIgniter\Model;
use Models\Entities\Country;

class CountryModel extends Model
{
    protected $table = 'Countries';
    protected $primaryKey = 'Id';
    protected $allowedFields = [
      'Id', 'Name'
    ];

    public function findAll(int $limit = 0, int $offset = 0)
    {
        $builder = $this->builder($this->table);

        $query = $builder->select();
        if ($limit > 0)
            $query = $query->limit($limit);
        if ($offset > 0)
            $query = $query->offset($offset);

        $response = $query->get();
        $countries = [];
        foreach ($response->getResultArray() as $countryRow)
            $countries[] = Country::parseFromArray($countryRow);

        $response->freeResult();
        return $countries;
    }

    public function findByName(string $name) {
        $builder = $this->builder($this->table);
        $query = $builder->where('Name', $name);

        $response = $query->get();
        $country = Country::parseFromArray($response->getRowArray());

        $response->freeResult();
        return $country;
    }
}