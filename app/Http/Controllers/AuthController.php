<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Custom\StatusController;
use App\Custom\ValidatorAppController;
use OpenApi\Annotations as OA;

use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{



    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     tags={"Usuarios"},
     *     summary="Authenticate user and generate JWT token",
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="200", description="Login successful"),
     *     @OA\Response(response="401", description="Invalid credentials")
     * )
     */
    public function login(Request $request):JsonResponse
    {
        try {

            return response()->json(User::setLogin($request));

        } catch (JWTException $e) {

            Log::info("Error exception login :: could_not_create_token./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception login.'));

        }
    }


    /**
     * @OA\Post(
     *     path="/api/auth/register",
     *     tags={"Usuarios"},
     *     summary="Register a new user",
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="User's name",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="User's email",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password",
     *         in="query",
     *         description="User's password",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="password_confirmation",
     *         in="query",
     *         description="User's password_confirmation",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="institution",
     *         in="query",
     *         description="User's institution",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(response="201", description="User registered successfully"),
     *     @OA\Response(response="422", description="Validation errors")
     * )
     */
    public function register(Request $request):JsonResponse
    {

        try {

            return response()->json(User::setRegister($request));

        } catch (\Exception $e) {

            Log::info("Error exception register./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception register.'));

        }
    }


     /**
     * @OA\post(
     *     path="/api/auth/logout",
     *     tags={"Usuarios"},
     *     summary="Change token  update",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function logout():JsonResponse
    {
        try {

            JWTAuth::invalidate();
            return  response()->json(StatusController::successfullMessage(201, 'Logout successfull', true, 0, ['message' => 'Successfully logged out',]));

        } catch (\Exception $e) {
            Log::info("Error exception logout./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception logout.'));
        }

    }

    /**
     * @OA\Get(
     *     path="/api/auth/refresh",
     *     tags={"Usuarios"},
     *     summary="Change token  update",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function refresh():JsonResponse
    {

        try{
            $data =  [
                'access_token' => JWTAuth::refresh(),
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
            ];
            return response()->json(StatusController::successfullMessage(201, 'Refresh successfull', true, count($data), $data));

        }catch (\Exception $e) {
            Log::info('Error exception refresh./'. $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception refresh.'));
        }

    }

    /**
     * @OA\Get(
     *     path="/api/auth/user",
     *     tags={"Usuarios"},
     *     summary="Get logged-in user details",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function user():JsonResponse
    {
        try{
            return response()->json(StatusController::successfullMessage(201, 'Data user sesion', true, 0, JWTAuth::user()));
        }catch (\Exception $e) {
            Log::info('Error exception user/'. $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception user.'));
        }
    }

      /**
     * @OA\Get(
     *     path="/api/auth/userAll",
     *     tags={"Usuarios"},
     *     summary="Get logged-in userAll details",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */

    public function userAll():JsonResponse
    {
        try{
            return response()->json(User::setUserAll());
        }catch (\Exception $e) {
            Log::info('Error exception user/'. $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception userAll.'));


        }
    }

   /* public function getAuthenticatedUser()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        return response()->json(compact('user'));
    }*/
}
