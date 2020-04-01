<?php


namespace SIGA\Acl;


use SIGA\Acl\Models\Permission;
use Illuminate\Support\Str;

class Helper
{
    /**
     * @var array
     */
    private $permissions = [];

    /**
     * @var array
     */
    private $groups = [
        'index'=>'List',
        'create'=>'Create',
        'store'=>'Store',
        'show'=>'Show',
        'edit'=>'Edit',
        'update'=>'Update',
        'destroy'=>'Destroy',
    ];

    /**
     * @var array
     */
    private $ignore = ['auth','store','auto-route','roles','permissions','pos-events','translate'];

    /**
     * @var array
     */
    private $required = ['admin'];

    public function __construct(Permission $permission)
    {


        foreach (\Route::getRoutes() as $route) {

            if (isset($route->action['as'])):

                $data = explode(".", $route->action['as']);

                if ($this->getIgnore($data)):

                    if ($this->getRequired($data)):

                        if(!$permission->findBy(['name' => $route->action['as']])->first()) {

                            $group = last($data);

                            $this->setPermission($group, $route->action['as'], Str::title(str_replace(".", " ", $route->action['as'])));

                        }

                    endif;

                endif;

            endif;
        }
    }

    public function getPermissions($current){


        if($current){
            $this->setPermission($current->groups, $current->name,  Str::title(str_replace(".", " ", $current->name)));
        }
        return $this->permissions;
    }

    private function setPermission($group, $permission,$label){

        if(in_array($group, array_keys($this->groups))){

            $this->permissions[$group][$permission] = $label;
        }

        return $this;
    }


    private function getIgnore($value){

        $result = true;

        foreach ($this->ignore as $item){

            if(in_array($item, $value)){

                $result = false;
            }
        }

        return $result;
    }


    private function getRequired($value){

        $result = false;

        foreach ($this->required as $item){

            if(in_array($item, $value)){

                $result = true;
            }
        }

        return $result;
    }
}
