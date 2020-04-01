<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */
namespace SIGA\Acl\Models;

use SIGA\TraitTable;
use Illuminate\Database\Eloquent\Model;
use SIGA\Acl\Concerns\HasPermissions;
use SIGA\Acl\Contracts\Role as RoleContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model implements RoleContract
{
    use HasPermissions,TraitTable;

    public $incrementing = false;

    protected $keyType = "string";

    protected $appends = ['link'];
    /**
     * The attributes that are fillable via mass assignment.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug','description', 'special', 'status'];

    protected $casts = [
        'created_at'=>'date:d/m/Y',
        'updated_at'=>'date:d/m/Y',
    ];
    /**
     * Create a new Role instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(config('acl.tables.roles'));
    }

    /**
     * Roles can belong to many users.
     *
     * @return Model
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(config('auth.model') ?: config('auth.providers.users.model'))->withTimestamps();
    }

    /**
     * Determine if role has permission flags.
     *
     * @return bool
     */
    public function hasPermissionFlags(): bool
    {
        return ! is_null($this->special);
    }
    /**
     * Determine if the requested permission is permitted or denied
     * through a special role flag.
     *
     * @return bool
     */
    public function hasPermissionThroughFlag(): bool
    {
        if ($this->hasPermissionFlags()) {
            return ! ($this->special === 'no-access');
        }
        return true;
    }

    public function init()
    {
    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }

}
