<?php

namespace App\Services;

use App\Repositories\ReadBarCodeRepository;

class ReadBarCodeService extends BaseService
{
    public function __construct(ReadBarCodeRepository $readBarCodeRepository)
    {
        $this->repo = $readBarCodeRepository;
    }
}