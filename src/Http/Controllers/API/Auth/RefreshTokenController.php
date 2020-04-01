<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Http\Controllers\API\Auth;

use Tymon\JWTAuth\Facades\JWTAuth;

class RefreshTokenController extends AbstractController
{

    public function __invoke()
    {
        return $this->respondWithToken(JWTAuth::parseToken()->refresh());
    }
}
