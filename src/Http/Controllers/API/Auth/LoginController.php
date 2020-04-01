<?php


namespace SIGA\Http\Controllers\API\Auth;


use SIGA\Http\Requests\ProfileRequest;

class AuthController extends AbstractController
{

    public function __invoke(ProfileRequest $profileRequest)
    {
        dd($profileRequest->all());
    }
}
