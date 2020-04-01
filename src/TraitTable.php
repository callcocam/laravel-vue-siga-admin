<?php


namespace SIGA;

use Ramsey\Uuid\Uuid;
use SIGA\TableView\TableView;
use Illuminate\Database\Eloquent\SoftDeletes;
use SIGA\Tenant\BelongsToTenants;
use SIGA\Common\{Update,Create,Delete,Eloquent,Select};

trait TraitTable
{
    use Select,Eloquent,Create,Update,Delete, SoftDeletes,BelongsToTenants;

    protected $queryParams = [];
    protected $data = [];
    protected $headers = [];
    protected $options = [];
    protected $removeOptions = ['value'];

    protected $model;

    protected $lastId;

    protected $messages=[];

    protected $results = [
        'result' => false,
        'type' => 'is-danger',
        'errors' => "Falhou, não foi possivel realizar a operação!!",
        'message' => "Falhou, não foi possivel realizar a operação!!",
        'title' => 'Operação:'
    ];


    abstract public function init($tableView);

    abstract public function initFilter($query);


    public function render($id=null){

        $this->queryParams = request()->query();

        if($id){
            $this->getSources()->where($this->getKeyName(), $id);
        }

        $this->initFilter($this->getSources());

        $forgings =  $this->innerJoin();


        /**
         * @var TableView $tableView
         */
        $tableView = tableView($this->getSources());

        $tableView->forgings($forgings);

        $this->redirect($this->addIndex());

        $tableView->appendsQueries(true);

        $tableView->column($this->getKeyName())->format('hidden');

        $this->init($tableView);

        $tableView->paginate($this->params('perPage',15));

        $data = $this->data($tableView);

        foreach($tableView->columns() as $column):

            $this->headers[] = $column->toArray($this->removeOptions);

        endforeach;

        $this->data['query'] = $this->queryParams;
//
       // $this->data['headers'] = $this->headers;

        //$this->data['options'] = $this->options;

       // $this->data['results'] = $this->getResults();

        $this->data['rows'] = $data;

        return $this->data;
    }

    /**
     * @param $title
     */
    protected function title($title){

        $this->options['title'] = $title;
    }

    /**
     * @param $subtitle
     */
    protected function subtitle($subtitle){

        $this->options['subtitle'] = $subtitle;
    }


    /**
     * @param array $redirect
     */
    protected function redirect($redirect=[]){

        $this->options['redirect'] = $redirect;
    }

    /**
     * @param $key
     * @param null $default
     * @return |null
     */
    protected function params($key, $default=null){

        if(isset($this->queryParams[$key]))
            return $this->queryParams[$key];

        return $default;
    }

    /**
     * @return array
     */
    protected function paramsAll(){

        return $this->queryParams;
    }

    /**
     * @param $key
     * @param null $default
     * @return |null
     */
    protected function header($key, $default=null){

        if(isset($this->headers[$key]))
            return $this->headers[$key];

        return $default;
    }


    /**
     * @return array
     */
    public function getResults()
    {

        return $this->results;
    }


    /**
     * @param $key
     * @return bool
     */
    public function getResult($key)
    {
        if (isset($this->results[$key])) {
            return $this->results[$key];
        }
        return false;
    }

    /**
     * @return string
     */
    public function getResultLastId()
    {
        if(is_string($this->lastId)){
            return $this->lastId;
        }
        if($this->lastId){
            return $this->lastId->toString();
        }
        return $this->lastId;
    }

    protected function setMessages($result, $operation="index"){

        $messageAppend = [];

        if($this->messages){

            foreach ($this->messages as $message){

                $messageAppend[] = $message;

            }

            $this->results['logs'] =  $messageAppend;
        }
        $this->results['title'] = config("siga.admin.table.{$operation}.messages.title",'Operação:');

        if($result){
            $this->results['result'] = $result;
            $this->results['type'] = config("siga.admin.table.{$operation}.messages.type.success",'success:');
            $this->results['redirect'] = $this->addIndex();
            $this->results['messages'] =  config("siga.admin.table.{$operation}.messages.message.success","Realizada com sucesso, registro foi excluido com sucesso!!");
            return $result;
        }

        $this->results['result'] = $result;
        $this->results['type'] = config("siga.admin.table.{$operation}.messages.type.error",'danger:');
        $this->results['messages'] =  sprintf(config("siga.admin.table.{$operation}.messages.message.error","Falhou, não foi possivel encontrar o registro - %s!!"), $this->getKey());
        return $result;
    }

}
