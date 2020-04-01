<?php


namespace SIGA;


use SIGA\TableView\TableView;

trait TraitTable
{
    protected $queryParams = [];
    protected $data = [];
    protected $headers = [];
    protected $options = [];

    abstract public function init($tableView);

    abstract public function initFilter($query);

    public function render($id=null){

        $this->queryParams = request()->query();

        if($id){
            $this->getSources()->where($this->getKeyName(), $id);
        }
        /**
         * @var TableView $tableView
         */
        $tableView = tableView($this->getSources());

        $this->redirect($this->addIndex());

        $this->initFilter($this->getSources());

        $tableView->column('id')->format('hidden');

        $this->init($tableView);

        $tableView->paginate($this->params('perPage',15));

        $data=[];

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

        foreach($tableView->columns() as $column):

            $this->headers[] = $column->toArray(['value']);

        endforeach;

        $this->data['query'] = $this->queryParams;

        $this->data['headers'] = $this->headers;

        $this->data['options'] = $this->options;

        $this->data['results'] = $this->getResults();

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

}
