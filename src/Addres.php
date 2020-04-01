<?php


namespace SIGA;


use Illuminate\Database\Eloquent\Model;

class Addres extends Model
{

    public $incrementing = false;

    protected $keyType = "string";

    protected $table="address";

    public function addresable(){

        return $this->morphTo();
    }
}
