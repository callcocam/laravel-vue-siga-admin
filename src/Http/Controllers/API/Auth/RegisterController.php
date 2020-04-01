<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Http\Controllers\API\Auth;


use SIGA\Http\Requests\RegisterRequest;

class RegisterController extends AbstractController
{

    public function __invoke(RegisterRequest $registerRequest)
    {
        $result = User::create([
            'name' => $registerRequest->get('name'),
            'email' => $registerRequest->get('email'),
            'password' => Hash::make($registerRequest->get('password')),
        ]);

        if($result)
            return response()->json($result);

        return response()->json(['error' => 'Unauthorized'], 401);

    }
}
