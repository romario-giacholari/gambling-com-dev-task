<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AffiliatesFileReader\IAffiliatesFileReader;

class AffiliatesInvitationApiController extends Controller
{
    public function __construct(
        private readonly IAffiliatesFileReader $affiliatesFileReader
    ) {}

    public function invite(Request $request)
    {
        $request->validate([
            'affiliates' => 'required|file',
        ]);
    
        $filteredAffiliatesWithinRange = [];
        $file = $request->file('affiliates');

        if (!$file->isValid()) {
            return response()->json([
                'error' => 'Uploaded file is not valid.',
            ], 422);
        }
    
        try {
            $affiliates = $this->affiliatesFileReader->read($file);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Could not read the affiliates file.',
                'details' => $e->getMessage()
            ], 500);
        }

        $affiliatesWithinRange = $this->affiliatesFileReader->filterByRange($affiliates);

        if (empty($affiliatesWithinRange)) {
            return response()->json([
                'error' => 'No affiliates found within the target range.',
            ], 404);
        }

        $filteredAffiliatesWithinRange = array_map(function($affiliate) {
            return [
                'affiliate_id' => $affiliate['affiliate_id'],
                'name' => $affiliate['name'],
            ];
        }, $affiliatesWithinRange);

        usort($filteredAffiliatesWithinRange, function ($a, $b) {
            return $a['affiliate_id'] <=> $b['affiliate_id'];
        });
    
        return response()->json([
            'data' => $filteredAffiliatesWithinRange,
        ]);
    }
}
