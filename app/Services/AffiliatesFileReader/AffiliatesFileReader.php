<?php

namespace App\Services\AffiliatesFileReader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AffiliatesFileReader
{
    public function read(UploadedFile $file): array
    {
        $affiliates = [];
        $handle = fopen($file->getRealPath(), 'r');
    
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $data = json_decode(trim($line), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $affiliates[] = $data;
                }
            }
            fclose($handle);
        }

        return $affiliates;
    }
}