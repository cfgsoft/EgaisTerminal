<?php

namespace App\Repositories;

use App\ReadBarCode;

class ReadBarCodeRepository extends BaseRepository
{
    public function __construct(ReadBarCode $readBarCode)
    {
        $this->model = $readBarCode;
    }
}