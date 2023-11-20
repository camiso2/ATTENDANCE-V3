<?php

namespace App\Http\Controllers;

use App\Custom\StatusController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenApi\Annotations as OA;
use Tymon\JWTAuth\Exceptions\JWTException;

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
    public function login(Request $request): JsonResponse
    {
        try {
            echo "test";
            return response()->json(User::setLogin($request));

        } catch (JWTException $e) {

            Log::info("Error JWTException login :: could_not_create_token./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error JWTException login.'));

        } catch (\Exception $e) {

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
    public function register(Request $request): JsonResponse
    {

        try {

            return response()->json(User::setRegister($request));

        } catch (\Exception $e) {

            Log::info("Error exception register./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception register.'));

        } catch (JWTException $e) {

            Log::info("Error JWTException register :: not found register./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error JWTException register.'));

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

    public function logout(): JsonResponse
    {
        try {
            return response()->json(User::selLogout());

        } catch (\Exception $e) {
            Log::info("Error exception logout./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception logout.'));
        } catch (JWTException $e) {

            Log::info("Error JWTException logout :: not found logout./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error JWTException logout.'));

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

    public function refresh(): JsonResponse
    {

        try {

            return response()->json(User::setRefresh());

        } catch (\Exception $e) {
            Log::info('Error exception refresh./' . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception refresh.'));
        } catch (JWTException $e) {

            Log::info("Error JWTException refresh :: not found refresh./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error JWTException refresh.'));

        }

    }

    /**
     * @OA\Get(
     *     path="/api/auth/userSession",
     *     tags={"Usuarios"},
     *     summary="Get logged-in user details",
     *     @OA\Response(response="200", description="Success"),
     *     security={{"bearerAuth":{}}}
     * )
     */
    public function userSession(): JsonResponse
    {
        try {
            return response()->json(User::setUserSession());
        } catch (\Exception $e) {
            Log::info('Error exception userSession/' . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception userSession.'));
        } catch (JWTException $e) {

            Log::info("Error JWTException userSession :: not found userSession./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error JWTException userSession.'));

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

    public function userAll(): JsonResponse
    {
        try {
            return response()->json(User::setUserAll());
        } catch (\Exception $e) {
            Log::info('Error exception userAll/' . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error exception userAll.'));

        } catch (JWTException $e) {

            Log::info("Error JWTException userSession :: not found userAll./" . $e->getMessage());
            return response()->json(StatusController::eMessageError([$e->getMessage()], 'Error JWTException userAll.'));

        }

    }

}
