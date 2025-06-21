<?php

namespace Tests\Unit;

use App\Services\AffiliatesFileReader\AffiliatesFileReader;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class AffiliatesFileReaderTest extends TestCase
{
    private readonly AffiliatesFileReader $affiliatesFileReader;

    public function setUp(): void
    {
        parent::setUp();
        $this->affiliatesFileReader = new AffiliatesFileReader();
    }

    public function testItReadsAValidFile()
    {
        $file = new UploadedFile(
            base_path('tests/data/affiliates.txt'),
            'affiliates.json',
            'application/json',
            null,
            true
        );

        $data = $this->affiliatesFileReader->read($file);

        $this->assertNotEmpty($data);
    }

    public function testItDoesNotReadAnInvalidFile()
    {
        $file = new UploadedFile(
            base_path('tests/data/invalid-affiliates.txt'),
            'affiliates.json',
            'application/json',
            null,
            true
        );

        $data = $this->affiliatesFileReader->read($file);

        $this->assertEmpty($data);
    }

    public function testItFiltersAffiliatesByRange()
    {
        $file = new UploadedFile(
            base_path('tests/data/affiliates.txt'),
            'affiliates.json',
            'application/json',
            null,
            true
        );

        $data = $this->affiliatesFileReader->read($file);
        $filteredAffiliatesWithinRange = $this->affiliatesFileReader->filterByRange($data);
        $filteredAndSortedAffiliatesWithinRange = array_map(function($affiliate) {
            return [
                'affiliate_id' => $affiliate['affiliate_id'],
                'name' => $affiliate['name'],
            ];
        }, $filteredAffiliatesWithinRange);

        usort($filteredAndSortedAffiliatesWithinRange, function ($a, $b) {
            return $a['affiliate_id'] <=> $b['affiliate_id'];
        });

        $this->assertNotEmpty($filteredAndSortedAffiliatesWithinRange);
        $this->assertSame([
                [
                    "affiliate_id" => 4,
                    "name" => "Inez Blair"
                ],
                [
                    "affiliate_id" => 5,
                    "name" => "Sharna Marriott"
                ],
                [
                    "affiliate_id" => 6,
                    "name" => "Jez Greene"
                ],
                [
                    "affiliate_id" => 8,
                    "name" => "Addison Lister"
                ],
                [
                    "affiliate_id" => 11,
                    "name" => "Isla-Rose Hubbard"
                ],
                [
                    "affiliate_id" => 12,
                    "name" => "Yosef Giles"
                ],
                [
                    "affiliate_id" => 13,
                    "name" => "Terence Wall"
                ],
                [
                    "affiliate_id" => 15,
                    "name" => "Veronica Haines"
                ],
                [
                    "affiliate_id" => 17,
                    "name" => "Gino Partridge"
                ],
                [
                    "affiliate_id" => 23,
                    "name" => "Ciara Bannister"
                ],
                [
                    "affiliate_id" => 24,
                    "name" => "Ellena Olson"
                ],
                [
                    "affiliate_id" => 26,
                    "name" => "Moesha Bateman"
                ],
                [
                    "affiliate_id" => 29,
                    "name" => "Alvin Stamp"
                ],
                [
                    "affiliate_id" => 30,
                    "name" => "Kingsley Vang"
                ],
                [
                    "affiliate_id" => 31,
                    "name" => "Maisha Mccarty"
                ],
                [
                    "affiliate_id" => 39,
                    "name" => "Kirandeep Browning"
                ]
            ], $filteredAndSortedAffiliatesWithinRange);
    }
}
