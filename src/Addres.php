<?php


namespace SIGA;


use Illuminate\Database\Eloquent\Model;

class Addres extends Model
{

    use TraitTable;

    public $incrementing = false;

    protected $keyType = "string";

    protected $table="address";

    public function addresable(){

        return $this->morphTo();
    }

    public function init($tableView)
    {
        // TODO: Implement init() method.
    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }
}
