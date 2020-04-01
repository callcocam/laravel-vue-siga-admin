<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */
namespace SIGA\Acl\Models;

use SIGA\TraitTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use SIGA\Acl\Concerns\RefreshesPermissionCache;
use SIGA\Acl\Contracts\Permission as PermissionContract;

class Permission extends Model implements PermissionContract
{
    use RefreshesPermissionCache,TraitTable;
    public $incrementing = false;

    protected $keyType = "string";

    protected $appends = ['link'];
    /**
     * The attributes that are fillable via mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'groups', 'description', 'status','created_at','updated_at'];

    /**
     * Create a new Permission instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('acl.tables.permissions'));
    }

    /**
     * Permissions can belong to many roles.
     *
     * @return Model
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(config('acl.models.role'))->withTimestamps();
    }

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }

}
