<?php

namespace App\Services\AffiliatesFileReader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class AffiliatesFileReader implements IAffiliatesFileReader
{
    public const DUBLIN_LAT = 53.3340285;
    public const DUBLIN_LON = -6.2535495;
    public const MAX_DISTANCE_KM = 100;

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

    public function filterByRange(array $affiliates): array
    {
        $filteredAffiliates = [];

        if(!empty($affiliates)) {
            foreach ($affiliates as $affiliate) {
                if (isset($affiliate['latitude'], $affiliate['longitude']) && $this->haversineGreatCircleDistance(self::DUBLIN_LAT, self::DUBLIN_LON, (float)$affiliate['latitude'], (float)$affiliate['longitude']) <= self::MAX_DISTANCE_KM) {
                    $filteredAffiliates[] = $affiliate;
                }
            }
        }

        return $filteredAffiliates;
    }

    private function haversineGreatCircleDistance(float $latitudeFrom, float $longitudeFrom, float $latitudeTo, float $longitudeTo, float $earthRadius = 6371)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos($latFrom) * cos($latTo) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
