<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Http\Controllers\API;

use SIGA\Http\Requests\UserRequest;
use SIGA\User;

class MenuController extends AbstractController
{

    protected $model = Menu::class;


    public function index()
    {

        $data = [
            [
                "name"=>"admin.users.index",
                "path"=>"users",
                'component'=>"@views/admin/AbstractList",
                'redirect'=>'admin.users.list',
                'children'=>[
                    "list"=>[
                        'name'=>'admin.users.listar',
                        'path'=>'list',
                        'component'=>"@views/admin/AbstractList"
                    ],
                    "create"=>[
                        'name'=>'admin.users.listar',
                        'path'=>'list',
                        'component'=>"@views/admin/AbstractList"
                    ],
                    "edit"=>[
                        'name'=>'admin.users.edit',
                        'path'=>':id/edit',
                        'component'=>"@views/admin/AbstractForm"
                    ],
                    "show"=>[
                        'name'=>'admin.users.show',
                        'path'=>':id/show',
                        'component'=>"@views/admin/AbstractShow"
                    ]
                ]
            ],

        ];
        return response()->json($data);
    }

    public function store(UserRequest $request)
    {
       return parent::save($request);
    }
}
