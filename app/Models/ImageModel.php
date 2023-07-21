<?php

namespace Models;

use CodeIgniter\Model;
use Config\Services;
use Models\Entities\Image;

const PathToImageDirectory = "wwwroot/hotelImages/";
class ImageModel extends Model
{
    protected $table = 'Images';
    protected $primaryKey = 'Id';
    protected $allowedFields = [
        'Id', 'HotelId', 'ImagePath'
    ];

    public function findAll(int $limit = 0, int $offset = 0)
    {
        $builder = $this->builder($this->table);
        $query = $builder
            ->select('Images.Id, Images.ImagePath, Hotels.Name as HotelName')
            ->join('Hotels', 'Hotels.Id = Images.HotelId');

        if ($limit > 0)
            $query = $query->limit($limit);
        if ($offset > 0)
            $query = $query->offset($offset);

        $response = $query->get();
        $images = [];
        foreach ($response->getResultArray() as $imageRow)
            $images[] = Image::parseFromArray($imageRow);

        $response->freeResult();
        return $images;
    }

    public function find($id = null)
    {
        $builder = $this->builder($this->table);
        $query = $builder
            ->select('Images.Id, Images.ImagePath, Hotels.Name as HotelName')
            ->join('Hotels', 'Hotels.Id = Images.HotelId')
            ->where('Images.Id', $id);

        $response = $query->get();
        return Image::parseFromArray($response->getRowArray());
    }

    public function insertForHotel(ImageDto $uploadedImage): void
    {
        $hotelModel = \model('Models\HotelModel');
        $hotelId = $hotelModel->findByName($uploadedImage->hotelName)->id;

        $pathToHotelImageDirectory = PathToImageDirectory."$hotelId/";
        if (!is_dir($pathToHotelImageDirectory))
            mkdir(directory: $pathToHotelImageDirectory, recursive: true);

        $tokenGenerator = Services::tokenGenerator();
        $pathToImage = $pathToHotelImageDirectory.$tokenGenerator->generateToken(8).".jpg";
        move_uploaded_file($uploadedImage->uploadedFile['tmp_name'], $pathToImage);

        $builder = $this->builder($this->table);
        $builder->insert(['HotelId' => $hotelId, 'ImagePath' => $pathToImage]);
    }

}