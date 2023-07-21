<?php

namespace Services;

use Config\Services;
use IoUtils;
use Models\Entities\Image;
use Models\ImageDto;
use Models\ImageModel;
use Services\Abstractions\IImageRepository;

const PathToImageDirectory = "wwwroot/hotelImages/";
class DatabaseImageRepository implements IImageRepository
{
    private readonly ImageModel $context;
    public function __construct()
    {
        $this->context = model('Models\ImageModel');
    }

    /**
     * @inheritDoc
     */
    public function getAll(): array
    {
        return $this->context->findAll();
    }

    public function get(int $id): Image
    {
        return $this->context->find($id);
    }

    public function add(ImageDto $uploadedImage): void
    {
        $this->context->insertForHotel($uploadedImage);
    }

    public function delete(int $id): void
    {
        #region Deleting image file from server
        $pathToImage = $this->get($id)->imagePath;
        unlink($pathToImage);

        $directoryName = dirname($pathToImage);
        if (IoUtils::isDirectoryEmpty($directoryName)) {
            rmdir($directoryName);
        }
        #endregion

        #region Deleting image from DB
        $this->context->delete($id);
        #endregion
    }

}