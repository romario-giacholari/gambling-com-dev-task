<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AffiliatesInvitationController extends Controller
{
    public function invite(Request $request)
    {
        // $request->validate([
        //     'affiliates' => 'required|file|mimetypes:text/plain,application/json',
        // ]);
    
        $affiliates = [];
    
        // Get the uploaded file from the request
        $file = $request->file('affiliates');
    
        // Open a stream to read the file without storing
        if ($file->isValid()) {
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
        }
    
        return response()->json([
            'count' => count($affiliates),
            'data' => $affiliates,
        ]);
    }
}
