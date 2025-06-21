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
}
