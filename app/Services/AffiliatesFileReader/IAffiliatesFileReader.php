<?php

namespace App\Services\AffiliatesFileReader;
use Illuminate\Http\UploadedFile;

interface IAffiliatesFileReader
{
    public function read(UploadedFile $file): array;
    public function filterByRange(array $affiliates): array;
}