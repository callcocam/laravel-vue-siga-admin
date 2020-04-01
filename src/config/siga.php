<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

return [
    "table"=>[
        'admin'=>[
            'index'=>[
                'icon'=> "ListIcon",
                'route'=> "admin.%s.index",
                'class'=>"h-5 w-5 mr-4 hover:text-primary cursor-pointer",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>'primary',
                        'error'=>'danger',
                    ],
                    'type'=>[
                        'success'=>'primary',
                        'error'=>'danger',
                    ]
                ]
            ],
            'edit'=>[
                'icon'=> "Edit3Icon",
                'route'=> "admin.%s.edit",
                'class'=>"h-5 w-5 mr-4 hover:text-primary cursor-pointer",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>'primary',
                        'error'=>'danger',
                    ],
                    'type'=>[
                        'success'=>'success',
                        'error'=>'danger',
                    ]
                ]
            ],
            'show'=>[
                'function'=> "showRecord",
                'icon'=> "EyeIcon",
                'route'=> "admin.%s.show",
                'class'=>"h-5 w-5 mr-4 hover:text-primary cursor-pointer",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>'primary',
                        'error'=>'danger',
                    ],
                    'type'=>[
                        'success'=>'primary',
                        'error'=>'danger',
                    ]
                ]
            ],
            'create'=>[
                'function'=> "createRecord",
                'icon'=> "PlusIcon",
                'route'=> "admin.%s.create",
                'class'=>"h-5 w-5 mr-4 hover:text-primary cursor-pointer",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>'primary',
                        'error'=>'danger',
                    ],
                    'type'=>[
                        'success'=>'success',
                        'error'=>'danger',
                    ]
                ]
            ],
            'destroy'=>[
                'function'=> "confirmDeleteRecord",
                'icon'=> "Trash2Icon",
                'route'=> "admin.%s.destroy",
                'class'=>"h-5 w-5 mr-4 hover:text-primary cursor-pointer",
                'messages'=>[
                    'title'=>'',
                    'message'=>[
                        'success'=>"Realizada com sucesso, registro foi excluido com sucesso!!",
                        'error'=>"Falhou, não foi possivel encontrar o registro - %s!!",
                    ],
                    'type'=>[
                        'success'=>'success',
                        'error'=>'danger',
                    ]
                ]
            ]
        ],
        'eloquent'=>[
            'filter'=>[
                'default_date'=>'created_at'
            ]
        ]
    ],
    "image"=>[
        'no_image'=>"/storage/default/no-image-available-grid.png",
        'no_avatar'=>"/storage/users/no_avatar-%s.jpg",
        'no_avatar_male'=>"/storage/users/no_avatar-male.jpg",
        'no_avatar_female'=>"/storage/users/no_avatar-female.jpg",
    ]
];
