<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Http\Controllers\API;

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
