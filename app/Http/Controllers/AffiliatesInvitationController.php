<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AffiliatesFileReader\AffiliatesFileReader;

class AffiliatesInvitationController extends Controller
{
    public function __construct(
        private readonly AffiliatesFileReader $affiliatesFileReader
    ) {}

    public function invite(Request $request)
    {
        $request->validate([
            'affiliates' => 'required|file',
        ]);
    
        $filteredAffiliatesWithinRange = [];
        $file = $request->file('affiliates');
    
        if ($file->isValid()) {
            $affiliates = $this->affiliatesFileReader->read($file);
            $affiliatesWithinRange = $this->affiliatesFileReader->filterByRange($affiliates);

            if (!empty($affiliatesWithinRange)) {
                $filteredAffiliatesWithinRange = array_map(function($affiliate) {
                    return [
                        'affiliate_id' => $affiliate['affiliate_id'],
                        'name' => $affiliate['name'],
                    ];
                }, $affiliatesWithinRange);

                usort($filteredAffiliatesWithinRange, function ($a, $b) {
                    return $a['affiliate_id'] <=> $b['affiliate_id'];
                });
            }
        }
    
        return response()->json([
            'data' => $filteredAffiliatesWithinRange,
        ]);
    }
}
