<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Http\Controllers\API;

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
