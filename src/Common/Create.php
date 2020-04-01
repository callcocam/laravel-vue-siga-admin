<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace App\Suports\Common;


trait Create
{

    protected $errorsKeysCreate = [];

    public function createBy(&$input)
    {
        array_push($this->fillable,'company_id','uuid','created_at','updated_at');

        $this->results['type'] = Options::MESSAGE_TYPE_ERROR;
        $this->results['result'] = false;
        $this->results['title'] = Options::DEFAULT_MESSAGE_TITLE;
        $this->results['table'] = $this->table;

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
            dd($this->messages);
            if ($this->errorsKeysCreate) {

                foreach ($this->errorsKeysCreate as $key => $value) {

                    if (\Str::contains($e->getMessage(), $key)) {

                        $this->messages  = $value;

                    }
                }
            }
            return false;
        }

        if (!$this->model) :

            //$this->messages =  "Falhou, não foi possivel caastrar o registro!!";

            return false;

        endif;
        $this->lastId = $this->model->id;
        $input = array_merge($input, $this->model->toArray());
       // $message = sprintf( 'Realizada com sucesso, registro [ %s ] foi cadastrado!!', isset($input[Options::DEFAULT_COLUMN_SLUG_ORIGEM])?$input[Options::DEFAULT_COLUMN_SLUG_ORIGEM]:$this->lastId);
        $message = "Sucesso! O registro foi cadastrado!";
        $this->results['type'] = Options::MESSAGE_TYPE_SUCCESS;
        $this->results['result'] = true;
        $this->messages =  $message;
        return true;
    }
}
