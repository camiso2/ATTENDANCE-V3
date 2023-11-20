<?php
namespace App\Models;

use App\Custom\StatusController;
use App\Custom\ValidatorAppController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'institution',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Register user
     *
     * @param mixed $request
     *
     * @return array
     *
     */
    public static function setRegister($request): array
    {

        if (ValidatorAppController::getDataUserRegister($request)->fails()) {

            return StatusController::successfullMessage(422, 'Register validation error', false, count(ValidatorAppController::getDataUserRegister($request)->errors()), ['error' => ValidatorAppController::getDataUserRegister($request)->errors()]);
        }

        $account = User::create(array_merge(ValidatorAppController::getDataUserRegister($request)->validated(), ['password' => bcrypt($request->password)]));

        if ($account) {
            return StatusController::successfullMessage(201, 'Register successfull', true, $account->count(), ['user' => $account]);
        }
        return StatusController::successfullMessage(102, 'Register error', false, 0, ['error' => ['unknown error']]);
    }

    /**
     * Login user
     *
     * @param mixed $request
     *
     * @return array
     *
     */
    public static function setLogin($request): array
    {
        if (ValidatorAppController::getDataUserLogin($request)->fails()) {
            return StatusController::successfullMessage(422, 'Login validation error', false, count(ValidatorAppController::getDataUserLogin($request)->errors()), ['error' => ValidatorAppController::getDataUserLogin($request)->errors()]);
        }

        if (!$token = JWTAuth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return StatusController::successfullMessage(401, 'User not authorized', false, 0, ['error' => 'Unauthorized']);
        }

        $data = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ];
        return StatusController::successfullMessage(201, 'Successfully created token', true, count($data), $data);
    }

    /**
     * all users registereds
     *
     * @param mixed $request
     *
     * @return array
     *
     */
    public static function setUserAll(): array
    {

        $userAll = User::all();

        if ($userAll) {
            return StatusController::successfullMessage(201, 'Successfully all', true, $userAll->count(), [$userAll]);
        }

        return StatusController::successfullMessage(102, 'User error', false, 0, ['error' => ['unknown error']]);

    }

    /**
     * open logout user
     *
     * @return array
     *
     */
    public static function selLogout(): array
    {

        JWTAuth::invalidate();
        return StatusController::successfullMessage(201, 'Logout successfull', true, 1, ['message' => 'Successfully logged out']);

    }

    /**
     * refresh token access
     *
     * @return array
     *
     */
    public static function setRefresh(): array
    {

        $data = [
            'access_token' => JWTAuth::refresh(),
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ];
        return StatusController::successfullMessage(201, 'Refresh successfull', true, count($data), $data);
    }


    public static function setUserSession(): array{
        return StatusController::successfullMessage(201, 'Data user sesion', true, 0, JWTAuth::user());


    }

}
