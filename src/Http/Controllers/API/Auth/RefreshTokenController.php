<?php


namespace SIGA\Http\Controllers\API\Auth;


use SIGA\Http\Requests\ProfileRequest;

class LoginController extends AbstractController
{

    public function __invoke(ProfileRequest $profileRequest)
    {
        $credentials = $profileRequest->only('email', 'password');

        $authenticate = $this->guard()->attempt($credentials);
        if ($authenticate) {
            // Generate Token
            $token = \JWTAuth::fromUser($this->guard()->user());
            // Get expiration time
            $objectToken = \JWTAuth::setToken($token);

            $expiration = \JWTAuth::decode($objectToken->getToken())->get('exp');

            $user = $this->guard()->user();

            $user->append('cover');

            $user->append('address');

            return $this->respondWithToken($token,$user->toArray(), $expiration);
        }

        return response()->json([
            'error' => 'Unauthorized',
            'message' =>trans('auth.failed'),
            'errors'=>[
                'email'=>[trans('auth.failed')]
            ]], 500);

    }
}
