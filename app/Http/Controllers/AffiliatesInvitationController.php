<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AffiliatesFileReader\AffiliatesFileReader;

class AffiliatesInvitationController extends Controller
{
    public function __construct(
        private AffiliatesFileReader $affiliatesFileReader
    ) {}

    public function invite(Request $request)
    {
        // $request->validate([
        //     'affiliates' => 'required|file|mimetypes:text/plain,application/json',
        // ]);
    
        $affiliates = [];
        $file = $request->file('affiliates');
    
        if ($file->isValid()) {
            $affiliates = $this->affiliatesFileReader->read($file);
        }
    
        return response()->json([
            'count' => count($affiliates),
            'data' => $affiliates,
        ]);
    }
}
