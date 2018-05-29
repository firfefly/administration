<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\Brands;

class ImageUpload {

    private $targetDir;

    public function __construct($targetDir) {
        $this->targetDir = $targetDir;
    }

    public function upload(Brands $brand, UploadedFile $file) {
        $fileName = $file->getClientOriginalName();

        $file->move('../../' . $brand->getDir() . $this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function getTargetDir() {
        return $this->targetDir;
    }

}
