<?php

namespace SIGA\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SIGA\Http\Requests\UserRequest;
use SIGA\User;

class UserController extends AbstractController
{

    protected $model = User::class;


    public function store(UserRequest $request)
    {
       return parent::save($request);
    }
}
