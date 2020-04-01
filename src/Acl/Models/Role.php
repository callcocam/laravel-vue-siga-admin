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
use App\Suports\Table\Columns\Facades\HTML;
use App\Suports\Table\Columns\Facades\ID;
use App\Suports\Table\Columns\Facades\TEXT;
use App\TraitModel;
use App\TraitTable;
use Illuminate\Database\Eloquent\Model;
use App\Suports\Shinobi\Concerns\HasPermissions;
use App\Suports\Shinobi\Contracts\Role as RoleContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model implements RoleContract
{
    use HasPermissions, TraitModel,TraitTable, TraitForm, TraitShow;

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
        $this->setEndpoint();
        $this->setTable(config('shinobi.tables.roles'));
        $this->defaultOptions['endpoint'] = "roles";
        $this->defaultOptions['title'] = "Papeis";
        $this->headers = [
            ID::make('id')->render(),
            TEXT::make('name')->filter()->render(),
            HTML::make('permissions')->hiddenList()->cellRendererFramework('CellRenderObject')->format('object')->render(),
            TEXT::make('description')->filter()->render(),
        ];
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

        $this->getHeader('permissions')->getCell()->addDecorator('callable', [
            'closure' => function ($context, $record) {
                return $context;
            },
        ]);

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

        $this->add(FTEXT::make('name'));

        $this->add(FSTATUS::make('status'));

        $this->add(FTEXT::make('description'));

        if($this->newRecord){
            $this->add(FMULTICHECKBOX::make('permissions')->type('InputRenderPermissions')
                ->setSelected($this->getItemCheckBox($this->permissions()->get()))
                ->value_options($this->getItemsCheckBox(
                    Permission::query()
                        ->select(['id',app('db')->raw('CONCAT(name," - ", groups) AS full_name')])
                        ->orderByDesc('name')
                        ->get(),'full_name'))
            );
        }

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

    public function initShow($id)
    {

        $this->openShow($id);

        return $this->render();
    }
}
