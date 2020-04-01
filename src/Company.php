<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;


use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $incrementing = false;

    protected $keyType = "string";

    use TraitModel, TraitTable;

    public function init($tableView)
    {
       // $tableView->column('id')->format('hidden');
    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }
}