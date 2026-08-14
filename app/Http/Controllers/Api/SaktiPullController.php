<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SaktiApiService;

class SaktiPullController extends Controller
{
    protected $saktiApi;

    public function __construct(SaktiApiService $saktiApi)
    {
        $this->saktiApi = $saktiApi;
    }

    public function syncAsetTetap()
    {
        $result = $this->saktiApi->pullMasterAsetTetap();
        
        if ($result['status']) {
            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'data' => $result['data']
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => $result['message'],
            'data' => null
        ], 500);
    }

    public function syncPersediaan()
    {
        $result = $this->saktiApi->pullMasterPersediaan();
        
        if ($result['status']) {
            return response()->json([
                'status' => 'success',
                'message' => $result['message'],
                'data' => $result['data']
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => $result['message'],
            'data' => null
        ], 500);
    }
}