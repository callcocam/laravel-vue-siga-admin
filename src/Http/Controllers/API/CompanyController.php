<?php

namespace SIGA\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SIGA\Company;
use SIGA\Http\Requests\UserRequest;

class CompanyController extends AbstractController
{

    protected $model = Company::class;


    public function store(UserRequest $request)
    {
       return parent::save($request);
    }
}
