<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */
namespace SIGA\Common;


use Illuminate\Database\Query\Builder;

trait Eloquent
{
    /*
     *  Builder
     */
    protected $source;

    protected $forgingsIgnore=['companies'];
    protected $forgingsIgnoreColumns=['is_admin','email_verified_at','remember_token','deleted_at','company_id','password'];


    public function getSources()
    {
        if (!$this->source) {
            $this->source = $this->query();
        }
        return $this->source;
    }


    public function innerJoin(){

        $connection = $this->getSources()->getConnection()->getDoctrineConnection();

        $schema = $connection->getSchemaManager();

        $foreignKeys = $schema->listTableForeignKeys($this->getTable());

        $fields =[];

        if($foreignKeys){
            foreach ( $foreignKeys as $foreignKey ) {
                if(!in_array($foreignKey->getForeignTableName(), $this->forgingsIgnore)){
                    $columns = $schema->listTableColumns( $foreignKey->getForeignTableName() );
                    $fields[] = [
                        'name' => $foreignKey->getName(),
                        'field' => $foreignKey->getLocalColumns()[0],
                        'references' => $foreignKey->getForeignColumns()[0],
                        'on' => $foreignKey->getForeignTableName(),
                        'columns'=>$this->getFields($columns)
                    ];
                }

            }
        }
        return $fields;
    }

    protected function getFields($columns)
    {
        $fields = array();
        foreach ($columns as $column) {
            $name = $column->getName();
            if(!in_array($name, $this->forgingsIgnoreColumns)) {
                $fields[$name] = $column->getName();
            }
        }
        return $fields;
    }
    protected function order($headers)
    {
        $column = $this->getParams()->column;

        if(isset($headers[$column])){
            $column = $headers[$column]['alias'];
        }
        $order = $this->getParams()->order;

        $this->source->orderBy($column, $order);
    }

    protected function initQuery()
    {

        if ($this->getParams()->status) {

            if ($this->params('status') !="all") {
                $this->source->where([onfig('siga.eloquent.filter.default_date','created_at') => $this->params('status')]);
            }
        }

        if ($this->params('start') && $this->params('end')) {
            $this->source->whereBetween(onfig('siga.eloquent.filter.default_date','created_at'), [
                date_carbom_format($this->params('start'))->format('Y-m-d 00:00:00'),
                date_carbom_format($this->params('end'))->format('Y-m-d 23:59:59')
            ]);
        }


        if (request()->has('year'))
            $this->source->whereYear(config('siga.eloquent.filter.default_date','created_at'), '=', $this->params('year'));
        if (request()->has('month'))
            $this->source->whereMonth(config('siga.eloquent.filter.default_date','created_at'), '=', $this->params('month'));
        if (request()->has('day'))
            $this->source->whereDay(config('siga.eloquent.filter.default_date','created_at'), '=', $this->params('day'));
        if (request()->has('date'))
            $this->source->whereDate(config('siga.eloquent.filter.default_date','created_at'), '=', $this->params('date'));
        if (request()->has('number'))
            $this->source->where('number', '=', request()->get('number'));

    }



    /**
     * @param $tableView
     * @return array
     */
    protected function data($tableView){

        $data = [];

        foreach($tableView->data() as $dataModel){
            $temp=[];
            foreach($tableView->columns() as $column):

                $column->rowValue($dataModel);

                $temp[$column->propertyName()] = $column->toArray();

            endforeach;


            if($tableView->hasChildDetails()):
                // dump($this->tableView->getChildDetails($dataModel));
            endif;

            $data[] = $temp;
        }

        return $data;
    }

}
