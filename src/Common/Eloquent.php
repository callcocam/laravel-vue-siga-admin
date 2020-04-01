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

    /**
     * @var Builder
     */
    protected $queryBuilder;

    protected function order($headers)
    {
        $column = $this->getParams()->column;

        if(isset($headers[$column])){
            $column = $headers[$column]['alias'];
        }
        $order = $this->getParams()->order;

        $this->queryBuilder->orderBy($column, $order);
    }

    protected function initQuery($headers)
    {


        if ($this->getParams()->status) {

            if ($this->getParams()->status !="all") {
                $this->queryBuilder->where([$this->getOption(Options::DEFAULT_COLUMN_STATUS) => $this->getParams()->status]);
            }
        }

        if ($this->getParams()->start && $this->getParams()->end) {
            $this->queryBuilder->whereBetween($this->getOption(Options::DEFAULT_COLUMN_DATE), [
                date_carbom_format($this->getParams()->start)->format('Y-m-d 00:00:00'),
                date_carbom_format($this->getParams()->end)->format('Y-m-d 23:59:59')
            ]);
        }


        if (request()->has('year'))
            $this->queryBuilder->whereYear($this->getOption(Options::DEFAULT_COLUMN_DATE), '=', $this->getParams()->year);
        if (request()->has('month'))
            $this->queryBuilder->whereMonth($this->getOption(Options::DEFAULT_COLUMN_DATE), '=', $this->getParams()->month);
        if (request()->has('day'))
            $this->queryBuilder->whereDay($this->getOption(Options::DEFAULT_COLUMN_DATE), '=', $this->getParams()->day);
        if (request()->has('date'))
            $this->queryBuilder->whereDate($this->getOption(Options::DEFAULT_COLUMN_DATE), '=', $this->getParams()->date);
        if (request()->has('number'))
            $this->queryBuilder->where('number', '=', request()->get('number'));

        $Searchs = [];

        if ($headers) :

            foreach ($headers as $values) :

                if (isset($values['filter']) && $values['filter']) :

                    $Searchs[] = $values['alias'];

                endif;

            endforeach;

        endif;

        $anyKeyword = $this->getParams()->search;

        if ($Searchs && !is_null($anyKeyword)) :

            $Search = implode(",", $Searchs);

            if ($anyKeyword) :

                $this->queryBuilder->where(app('db')->raw("CONCAT_WS(' ', {$Search})"), "like", "%{$anyKeyword}%");

            endif;

        endif;
    }

    public function getData($columns = ["*"])
    {

        if($this->data)
            return $this->data;

        $headers = $this->getTables()->getHeadersArray();

        $this->queryBuilder = $this->getSources();

        $this->queryBuilder->select($columns);

        $this->order($headers);

        $this->initQuery($headers);

        $this->data = $this->queryBuilder->paginate($this->getParams()->perPage);

//dump($this->queryBuilder->toSql());
        //Log::debug($this->queryBuilder->toSql());
        //Log::debug("Params: page -> {$this->getParams()->page}, search -> {$this->getParams()->search}, limit -> {$this->getParams()->limit}, between -> {$this->getParams()->between}, status -> {$this->getParams()->status}");
        // $resource = $this->tables->getResource();


        return $this->data;
    }

}
