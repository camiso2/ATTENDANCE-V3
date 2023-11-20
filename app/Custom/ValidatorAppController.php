<?php

namespace App\Custom;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Custom\StatusController;


class ValidatorAppController
{

    /**
     * Validate data register user
     *
     * @param mixed $request
     *
     * @return $validator
     *
     */
    public static function getDataUserRegister($request){
        try{

            $validator = Validator::make($request->all(), [
                'name' => 'required|between:2,100',
                'email' => 'required|email|unique:users|max:50',
                'password' => 'required|confirmed|string|min:6',
                'institution' => 'required|string|min:1|unique:users|max:50',
            ]);
            return $validator;

        } catch (\Exception $e) {
            Log::info("Error exception getDataUserRegister./" . $e->getMessage());
            return StatusController::eMessageError([$e->getMessage()], 'Error exception getDataUserRegister.');

        }
    }

    /**
     * Validate data login user
     *
     * @param mixed $request
     *
     * @return $validator
     *
     */
    public static function getDataUserLogin($request){
        try{
            // $credentials = $request->only("email", "password");
            $validator = Validator::make($request->all(), [
                'email' => 'required',
                'password' => 'required',
            ]);
            return $validator;

        } catch (\Exception $e) {
            Log::info("Error exception getDataUserLogin./" . $e->getMessage());
            return StatusController::eMessageError([$e->getMessage()], 'Error exception getDataUserRegister.');

        }
    }


}



