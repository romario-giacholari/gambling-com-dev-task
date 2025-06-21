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

    public function testItReadAValidFile()
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
}
