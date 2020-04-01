<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA;

use App\User as AppUser;
use SIGA\Acl\Concerns\HasRolesAndPermissions;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends AppUser implements JWTSubject
{
 use TraitTable, TraitModel, HasRolesAndPermissions;

    public $incrementing = false;

    protected $keyType = "string";

    public function init(TableView\TableView $tableView)
    {
        $tableView->column('name');
        $tableView->column('email');
        $tableView->column('address')->format('address');
        $tableView->column('roles')->format('roles');
        $tableView->column('status','Status')->format('status');

        $tableView->closure('updated_at', function ($model) {
            return $model->updated_at->diffForHumans();
        });
        $tableView->closure('created_at', function ($model) {
            return $model->created_at->diffForHumans();
        });

        $tableView->setSearchableFields(['name','email']);

    }

    public function initFilter($query)
    {
        // TODO: Implement initQuery() method.
    }


    public function address(){

        return $this->morphOne(Addres::class, 'addresable')->select(['zip','city','state','country', 'street','district','number','complement']);
    }

    public function getAddressAttribute(){

        return $this->address();
    }
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return  [];
    }
}
