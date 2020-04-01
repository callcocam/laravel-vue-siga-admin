<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Common;

use SIGA\Company;
use SIGA\User;
use SIGA\File;
use Illuminate\Database\Query\Builder;

trait Select
{

    protected $source;


    public function author()
    {
        $user = $this->user()->first();
        if($user){
            $user->append('avatar');
            $user->append('created_mm_dd_yyyy');
        }

        return $user;
    }


    public function user()
    {

        return $this->belongsTo(User::class);
    }


    /**
     * @return File
     */
    public function file()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    public function getCompanyNameAttribute()
    {
        if($this->company()->count())
           return $this->company()->first()->name;

        return \Auth::user()->company->name;
    }

    public function company_name()
    {
        if($this->company()->count())
           return $this->company()->first()->name;

        return \Auth::user()->company->name;
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getQuery()
    {

        return parent::query();
    }

    public function getSources()
    {
        if (!$this->source) {
            $this->source = $this->query();
        }
        return $this->source;
    }

    public function findById($id, $columns = ['*'])
    {

        $result = $this->where([
            'id' => $id
        ])->first($columns);

        if ($result) {

            return $result;
        }
        return FALSE;
    }

    public function findByIdQuery($id, $columns = ['*'])
    {

        $result = $this->where([
            'id' => $id
        ])->select($columns);

        if ($result) {

            return $result;
        }
        return FALSE;
    }
    public function findAll($columns = ['*'])
    {
        return parent::all($columns);
    }

    public function findBy($where, $columns =["*"])
    {

        $result = $this->select($columns)->where($where);

        if ($result) {
            /**
             * @var $result Builder
             */
            return $result;
        }
        return FALSE;
    }

    public function addIndex($params=[]){

        return array_merge([
            'api' => route(sprintf(config('table.admin.index.route','admin.%s.index'), $this->getTable()), request()->query()),
            'query' => request()->query(),
            'name' => sprintf(config('table.admin.index.route','admin.%s.index'), $this->getTable()),
            'object' => [
                'name' => sprintf(config('table.admin.index.route','admin.%s.index'), $this->getTable()),
                'query' => request()->query(),
            ],
            'icon' => config('table.admin.index.icon',"ListIcon"),
            'function' =>config('table.admin.index.function',"addRecord"),
            'sgClass' => config('table.admin.index.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
        ], $params);
    }


}
