<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Custom\StatusController;
use OpenApi\Annotations as OA;

use Illuminate\Support\Facades\Log;

class InstitutionController extends Controller
{

     /**
     * @OA\Get(
     *     path="/api/auth/listAllInstutions",
     *     tags={"Instituciones"},
     *     summary="Get logged-in user details",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function listAllInstutions(){

        return response()->json([
            'message' => 'lista de instituciones .....',
        ]);


    }
}
