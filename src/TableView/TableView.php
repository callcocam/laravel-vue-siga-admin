<?php

namespace SIGA\TableView;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class TableView
{

    /**
     * @var Collection
     */
    protected $collection;
    protected $headers = [];
    protected $columns = [];
    protected $options = [
        'title'=>'Base Table',
        'subtitle'=>'Base Table Description',
        'redirect'=>[],
    ] ;
    protected $table;
    protected $classes = 'table';
    protected $paginator = null;
    protected $appendsQueries = false;
    protected $tableRowAttributes;
    protected $tableBodyClass;
    protected $childDetailsCallback = null;

    /** @var Builder */
    protected $builder;

    private $searchFields = [];

    public function __construct($data)
    {

        if ($data instanceof Collection) {
            $this->collection = $data;
        }

        if ($data instanceof Builder) {
            $this->builder = $data;

            $this->table = $this->builder->getModel()->getTable();

        }
    }

    public function childDetails($callback)
    {
        $this->childDetailsCallback = $callback;

        return $this;
    }

    public function hasChildDetails()
    {
        return (bool) $this->childDetailsCallback;
    }

    public function getChildDetails($model)
    {
        $closure = $this->childDetailsCallback;

        $html = $closure instanceof Closure ? $closure($model) : '';


        return $html;
    }

    public function paginate($perPage = 15, $page = null, $options = [])
    {

        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $this->applySearchFilter();

        if ($this->collection) {
            $this->paginator = new LengthAwarePaginator(
                $this->collection->forPage($page, $perPage),
                $this->collection->count(),
                $perPage, $page, $options);
        } else {
            $this->paginator = $this->builder->paginate($perPage, $this->alias(), 'page', $page);
        }

        return $this;
    }

    private function alias(){

        $alias=['*'];
        foreach ($this->columns() as $column) {
           $alias[] = $column->alias;
        }
        return $alias;
    }

    private function applySearchFilter()
    {
        $this->builder->select($this->alias());

        if (count($this->searchableFields()) && ! empty($this->searchQuery())) {

            if ($this->builder) {
                $keyword = strtolower($this->searchQuery());
                $this->builder->where(function (Builder $query) use ($keyword) {
                    foreach ($this->searchableFields() as $field) {
                        $query
                            ->orWhere($field, 'LIKE', "%$keyword%");
                    }
                });
            }

            //dd($this->builder->toSql());
        }
    }

    public function setSearchableFields($fields = [])
    {
        $this->searchFields = $fields;

        return $this;
    }

    public function searchableFields()
    {
        return $this->searchFields;
    }

    public function searchQuery()
    {
        return Request::get('search');
    }

    public function id()
    {
        return $this->id;
    }

    public function appendsQueries($append = true)
    {
        $this->appendsQueries = $append;

        return $this;
    }

    public function data()
    {
        if ($this->hasPagination()) {
            $params = [];
            if ($this->appendsQueries) {
                if (is_array($this->appendsQueries)) {
                    $params = App::make('request')->query->get($this->appendsQueries);
                } else {
                    $params = App::make('request')->query->all();
                }
            }

            return $this->paginator->appends($params)->setPath('');
        }

        $this->applySearchFilter();

        if ($this->collection) {
            return $this->collection;
        }

        return $this->builder->get();
    }

    /**
     * @param array $forgings
     * @return TableView
     */
    public function forgings(array $forgings): TableView
    {

        if($forgings){

            foreach ($forgings as $forging) {

                $this->builder->join(
                    $forging['on'],
                    sprintf( '%s.%s',$forging['on'],$forging['references']),
                    '=',
                    sprintf( '%s.%s',$this->builder->getModel()->getTable(),$forging['field'])
                );

                $this->inner($forging['on']);

                foreach ($forging['columns'] as $column) {

                    $this->column($column);
                }
            }
        }

        $this->inner($this->builder->getModel()->getTable());

        return $this;
    }
    /**
     * @param null $id
     * @return $this
     */
    public function render($id = null)
    {
        if (count($this->columns) == 0) {
            if ($this->collection->count() > 0) {
                $array = $this->collection->first()->toArray();

                foreach ($array as $key => $value) {
                    $this->column(str_replace('_', ' ', ucfirst($key)), $key);
                }
            }
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function hasPagination()
    {
        return (bool) $this->paginator;
    }

    /**
     * @return array
     */
    public function columns()
    {
        return $this->columns;
    }

    /**
     * @param $classes
     * @return $this
     */
    public function setTableClass($classes)
    {
        $this->classes = $classes;

        return $this;
    }

    /**
     * @return string
     */
    public function getTableClass()
    {
        return $this->classes;
    }

    /**
     * @param null $model
     * @return array|mixed
     */
    public function getTableRowAttributes($model = null)
    {
        if (is_array($this->tableRowAttributes)) {
            return $this->tableRowAttributes;
        }

        $closure = $this->tableRowAttributes;

        return $closure instanceof Closure ? $closure($model) : [];
    }

    /**
     * @param $data
     * @return $this
     */
    public function setTableRowAttributes($data)
    {
        $this->tableRowAttributes = $data ?? [];

        return $this;
    }

    /**
     * @param $class
     * @return $this
     */
    public function setTableBodyClass($class)
    {
        $this->tableBodyClass = $class;

        return $this;
    }

    /**
     * @return mixed
     */
    public function geTableBodyClass()
    {
        return $this->tableBodyClass;
    }


    /**
     * @param $name
     * @param null $title
     * @return $this
     */
    public function column($name, $title = null)
    {

        return $this->closure($name,null, $title);
    }

    /**
     * @param $table
     * @return $this
     */
    public function inner($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param $value
     * @param $callable
     * @param null $title
     * @return $this
     */
    public function closure( $name, $callable, $title = null)
    {

        if (!is_string($title)) {
            $title = str_replace('_', ' ', ucfirst($name));
        }

        $column = new TableViewColumn($title, $callable, $name, $this->table);

        $this->columns[] = $column;

        return $column;
    }

    public function __call($method, $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }
    }




}
