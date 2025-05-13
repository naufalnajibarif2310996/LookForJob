<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CohereService;

class CVController extends Controller
{
    protected $cohereService;

    public function __construct(CohereService $cohereService)
    {
        $this->cohereService = $cohereService;
    }

    public function create(Request $request)
    {
        $request->validate([
            'user_input' => 'required|string',
        ]);

        try {
            $cvContent = $this->cohereService->generateCV($request->input('user_input'));

            return response()->json([
                'success' => true,
                'cv' => $cvContent,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}