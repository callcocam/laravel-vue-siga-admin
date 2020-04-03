<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Http\Controllers;

use App\Http\Controllers\Controller;
use Psy\Util\Str;

class AdminController extends Controller
{

    public function index()
    {

        $menus = [
            [
                "name"=>"admin.users.index",
                "path"=>"users",
                'component'=>"@views/admin/AbstractPage",
                'redirect'=>'admin.users.list',
                'children'=>[
                    "list"=>[
                        'name'=>'admin.users.list',
                        'path'=>'list',
                        'component'=>"@views/admin/AbstractList",
                        "meta"=>[
                            "auth"=>true
                        ]
                    ],
                    "create"=>[
                        'name'=>'admin.users.listar',
                        'path'=>'list',
                        'component'=>"@views/admin/AbstractList",
                        "meta"=>[
                            "auth"=>true
                        ]
                    ],
                    "edit"=>[
                        'name'=>'admin.users.edit',
                        'path'=>':id/edit',
                        'component'=>"@views/admin/AbstractForm",
                        "meta"=>[
                            "auth"=>true
                        ]
                    ],
                    "show"=>[
                        'name'=>'admin.users.show',
                        'path'=>':id/show',
                        'component'=>"@views/admin/AbstractShow",
                        "meta"=>[
                            "auth"=>true
                        ]
                    ]
                ],
                "meta"=>[
                    "auth"=>true
                ]
            ],
            [
                "name"=>"admin.posts.index",
                "path"=>"posts",
                'component'=>"@views/admin/AbstractPage",
                'redirect'=>'admin.posts.list',
                'children'=>[
                    "list"=>[
                        'name'=>'admin.posts.list',
                        'path'=>'list',
                        'component'=>"@views/admin/AbstractList",
                        "meta"=>[
                            "auth"=>true
                        ]
                    ],
                    "create"=>[
                        'name'=>'admin.posts.listar',
                        'path'=>'list',
                        'component'=>"@views/admin/AbstractList",
                        "meta"=>[
                            "auth"=>true
                        ]
                    ],
                    "edit"=>[
                        'name'=>'admin.posts.edit',
                        'path'=>':id/edit',
                        'component'=>"@views/admin/AbstractForm",
                        "meta"=>[
                            "auth"=>true
                        ]
                    ],
                    "show"=>[
                        'name'=>'admin.posts.show',
                        'path'=>':id/show',
                        'component'=>"@views/admin/AbstractShow",
                        "meta"=>[
                            "auth"=>true
                        ]
                    ]
                ],
                "meta"=>[
                    "auth"=>true
                ]
            ],
        ];

       
        return view('siga::layouts.admin',[
            "menus"=>json_encode($menus)
        ]);
    }

}
