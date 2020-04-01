<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Common;


trait Create
{

    protected $errorsKeysCreate = [];

    public function createBy(&$input)
    {
        array_push($this->fillable,'company_id','uuid','created_at','updated_at');

        unset($input['id']);

        $data = [];

        foreach ($this->fillable as $value) :

            try {
                $data[$value] = $input[$value];
            } catch (\Exception $e) { }

        endforeach;

        try {
            $this->model = self::query()->create($data);

        } catch (\Illuminate\Database\QueryException $e) {

            $this->messages = $e->getMessage();

            if ($this->errorsKeysCreate) {

                foreach ($this->errorsKeysCreate as $key => $value) {

                    if (\Str::contains($e->getMessage(), $key)) {

                        $this->messages[]  = $value;

                    }
                }
            }
            return $this->setMessages(false,'create');
        }

        if (!$this->model) :

            //$this->messages =  "Falhou, não foi possivel caastrar o registro!!";

            return $this->setMessages(false,'create');

        endif;
        $this->lastId = $this->getKey();
        $input = array_merge($input, $this->model->toArray());
        return $this->setMessages(false,'create');
    }
}
