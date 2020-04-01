<?php

namespace SIGA\TableView;

class TableViewColumn
{

    protected $closure;

    protected $render = [
        'field'=>'',
        'name'=>'',
        'title'=>'',
        'alias'=>'',
        'label'=>'',
        'value'=>null,
        'sorter'=>false,
        'filter'=>false,
        'width'=>150,
        'options'=>[],
        'attributes'=>[],
        'format'=>'text',
        'icone'=>'icon-chevron-right',
        'hidden_list'=>true,
        'hidden_show'=>true,
        'hidden_detail'=>true,
        'hidden_create'=>true,
        'hidden_edit'=>true,
    ];


    public function __construct($title, $callable, $name, $table)
    {

        $this->title($title);

        $this->field($name);

        $this->label($title);

        $this->name(sprintf("%s_%s", $table, $name));

        $this->alias(sprintf("%s.%s as %s_%s", $table, $name, $table,$name));

        $this->callable($callable);

        $this->attribute('id', $name);

        $this->attribute('placeholder', $title);

    }

    public function propertyName()
    {
        return $this->render['name'];
    }

    public function callable($callable)
    {
        return $this->closure = $callable;
    }

    public function rowValue($model)
    {
        $closure = $this->propertyName();

        if($this->closure)
          $closure = $this->closure;

        if(is_callable($closure)){
            $rowValue =  $closure($model);

        }
        else
        {
            $rowValue =   $model->{$closure};
        }

        $this->render['value'] = $rowValue;

        return $rowValue;
    }

    /**
     * @param $field
     * @return $this
     */
    public function field($field)
    {
        $this->render['field'] = $field;

        return $this;
    }

     /**
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        $this->render['name'] = $name;

        return $this;
    }

    /**
     * @param $alias
     * @return $this
     */
    public function alias($alias)
    {
        $this->render['alias'] = $alias;

        return $this;
    }

    /**
     * @param $title
     * @return $this
     */
    public function title($title)
    {
        $this->render['title'] = $title;

        return $this;
    }

    /**
     * @param $label
     * @return $this
     */
    public function label($label)
    {
        $this->render['label'] = $label;

        return $this;
    }

    /**
     * @param $filter
     * @return $this
     */
    public function filter($filter)
    {
        $this->render['filter'] = $filter;

        return $this;
    }

    /**
     * @param $width
     * @return $this
     */
    public function width($width)
    {
        $this->render['width'] = $width;

        return $this;
    }

    public function format($format)
    {
        $this->render['format'] = $format;

        return $this;
    }

    public function icone($icone)
    {
        $this->render['icone'] = $icone;

        return $this;
    }

    public function hidden_list($hidden_list)
    {
        $this->render['hidden_list'] = $hidden_list;

        return $this;
    }

    public function hidden_show($hidden_show)
    {
        $this->render['hidden_show'] = $hidden_show;

        return $this;
    }

    public function hidden_detail($hidden_detail)
    {
        $this->render['hidden_detail'] = $hidden_detail;

        return $this;
    }

    public function hidden_create($hidden_create)
    {
        $this->render['hidden_create'] = $hidden_create;

        return $this;
    }

    public function hidden_edit($hidden_edit)
    {
        $this->render['hidden_edit'] = $hidden_edit;

        return $this;
    }

    /**
     * @param array $options
     * @return $this
     */
    public function options(array $options)
    {

        foreach ($options as $key => $option){

            $this->option($key, $option);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $attribute
     * @return $this
     */
    public function attribute($key, $attribute)
    {
        $this->render['attributes'][$key] = $attribute;

        return $this;
    }


    /**
     * @param array $options
     * @return $this
     */
    public function attributes(array $attributes)
    {
        foreach ($attributes as $key => $attribute){

            $this->attribute($key, $attributes);
        }

        return $this;
    }

    /**
     * @param $key
     * @param $option
     * @return $this
     */
    public function option($key, $option)
    {
        $this->render['options'][$key] = $option;

        return $this;
    }


    public function toArray($unset=[]){

        if($unset){

            foreach ($unset as $value){

                if (isset($this->render[$value])){

                    unset($this->render[$value]);

                }
            }

        }

        return $this->render;
    }

    public function __get($name)
    {
        return $this->render[$name];
    }

    public function __set($name, $value)
    {
        $this->render[$name] = $value;
    }
}
