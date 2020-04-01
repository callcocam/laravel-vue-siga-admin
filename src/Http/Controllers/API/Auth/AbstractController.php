<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use SIGA\Http\Requests\ProfileRequest;
use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AbstractController extends Controller
{
    /**
     * Reset the given user's password.
     *
     * @param ProfileRequest $request
     * @return void
     */
    public function profile(ProfileRequest $request)
    {

        $data = $request->all();
        /**
         * @var $user User
         */
        $user = $request->user();

        $user->fill($data);

        $user->save();

        return response()->json($user);

    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
        event(new PasswordReset($user));
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @param null $user
     * @param null $expiration
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user=null, $expiration=null)
    {
        return response()->json([
            'userData' => $user,
            'accessToken' => $token,
            'token_type' => 'bearer',
            'exp' => $expiration
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
