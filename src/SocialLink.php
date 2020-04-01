<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{

    use TraitTable;

    public $incrementing = false;

    protected $keyType = "string";

    protected $table = "social_links";

    protected $fillable = [
        'user_id','twitter','facebook','instagram','github','linkedin','codepen', 'slack','youtub','google','website','created_at','updated_at'
    ];

    public function social_linkable(){

        return $this->morphTo();
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
