<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Common;

use Illuminate\Database\Eloquent\Builder;
use SIGA\Company;
use SIGA\Processors\AvatarProcessor;
use SIGA\User;
use SIGA\File;

trait Select
{


    public function author()
    {
        $user = $this->user()->first();
        if($user){
            $user->append('avatar');
            $user->append('created_mm_dd_yyyy');
        }
        return $user;
    }


    /**
     * @return mixed
     */
    public function getUserAttribute()
    {
        return $this->user();
    }

    /**
     * @return mixed
     */
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

    /**
     * @return mixed
     */
    public function getCompanyNameAttribute()
    {
        return $this->company_name();
    }

    /**
     * @return mixed
     */
    public function company_name()
    {
        if($this->company()->count())
           return $this->company()->first()->name;

        return \Auth::user()->company->name;
    }

    /**
     * @return mixed
     */
    public function getCompanyAttribute()
    {
        return $this->company();
    }

    /**
     * @return mixed
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }


    public function getLinkAttribute(){

        return [
            'edit'=>$this->addEdit(),
            'show'=>$this->addShow(),
            'destroy'=>$this->addDestroy(),
        ];
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function getAvatarAttribute()
    {
        return AvatarProcessor::get($this);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function getCoverAttribute()
    {
        return AvatarProcessor::get($this);
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
