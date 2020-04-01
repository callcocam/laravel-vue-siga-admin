<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */
namespace App\Suports\Shinobi\Models;

use App\Suports\Form\Field\Facades\FID;
use App\Suports\Form\Field\Facades\FMULTICHECKBOX;
use App\Suports\Form\Field\Facades\FSTATUS;
use App\Suports\Form\Field\Facades\FTEXT;
use App\Suports\Form\Field\Facades\ROW;
use App\Suports\Form\Field\Facades\SECTION;
use App\Suports\Form\Field\Facades\TABS;
use App\Suports\Form\TraitForm;
use App\Suports\Show\TraitShow;
use App\Suports\Table\Columns\Facades\ID;
use App\Suports\Table\Columns\Facades\TEXT;
use App\TraitModel;
use App\TraitTable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Suports\Shinobi\Concerns\RefreshesPermissionCache;
use App\Suports\Shinobi\Contracts\Permission as PermissionContract;

class Permission extends Model implements PermissionContract
{
    use RefreshesPermissionCache, TraitModel,TraitTable, TraitForm, TraitShow;
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

        $this->setEndpoint();

        $this->setTable(config('shinobi.tables.permissions'));
        $this->defaultOptions['endpoint'] = "permissions";
        $this->defaultOptions['title'] = "Permissões";
        $this->headers = [
            ID::make('id')->hiddenList()->hiddenShow()->render(),
            TEXT::make('name')->filter()->render(),
            TEXT::make('description')->filter()->render(),
        ];
    }

    /**
     * Permissions can belong to many roles.
     *
     * @return Model
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(config('shinobi.models.role'))->withTimestamps();
    }

    public function init()
    {
        // TODO: Implement init() method.
    }

    public function initFilter($query)
    {
        // TODO: Implement initFilter() method.
    }

    /**
     * @param TraitModel $model
     * @return mixed
     */
    public function initForm($model)
    {
        $this->openForm($model);

        $this->add(FID::make('id'));

        $this->add(FID::make('slug'));

        $this->add(FSTATUS::make('status'));

        $this->add(FTEXT::make('name'));

        $this->add(FTEXT::make('description'));

        $tabs[] = TABS::add(
            ROW::add(
                [
                    SECTION::add('SectionRenderFields',$this->getElements($model))
                ]
            )->actions($this->getTable())

        )->setLabel('Setting')->render();
        return [
            'rows'=> $tabs,
            'options'=>$this->defaultOptions
        ];
    }

    public function initShow($model)
    {

        $this->openShow($model);

        return $this->showRender();
    }
}
