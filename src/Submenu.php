<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;


use Illuminate\Database\Eloquent\Model;

class Submenu extends Model
{
    public $incrementing = false;

    protected $keyType = "string";

    use  TraitTable;

    protected $fillable = [
        'company_id', 'user_id','title','name', 'path', 'url', 'auth', 'icone','ordering','description','created_at','updated_at'
    ];
    public function init($tableView)
    {
       // $tableView->column('id')->format('hidden');
    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }
}
