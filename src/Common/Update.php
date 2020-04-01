<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace App\Suports\Common;



use App\TraitModel;

trait Update
{
    public function updateBy(&$input,$id){
        array_push($this->fillable,'updated_at');
        $this->results['type'] = Options::MESSAGE_TYPE_ERROR;
        $this->results['result'] = false;
        $this->results['title'] = Options::DEFAULT_MESSAGE_TITLE;
        $this->results['table'] = $this->table;

        /**
         * @var $model TraitModel
         */
        $model = $this->find($id);

        $data =[];
        foreach ($this->fillable as $value):
            try{

                $data[$value] = $input[$value];

            }catch (\Exception $e){}
        endforeach;


        if(!$model):
            $this->messages = "Falhou, não foi possivel atualizar o registro, modelo não foi encontrado!!";
            return false;

        endif;

        unset($data['created_at']);

        $model->fill($data);

        if(!$model->save()):

            $this->messages = "Falhou, não foi possivel atualizar o registro!!";

            return false;

        endif;

        $this->model =  $this->findById($id);

        $input = array_merge($input, $this->model->toArray());

        $this->lastId =  $id;

        //$message = sprintf( 'Realizada com sucesso, registro [ %s ] foi atualizado com sucesso!!', isset($input[Options::DEFAULT_COLUMN_SLUG_ORIGEM])?$input[Options::DEFAULT_COLUMN_SLUG_ORIGEM]:$this->lastId);
        $message = "Sucesso! O registro foi atualizado!";

        $this->results['id'] =  $id;
        $this->results['result'] =  true;
        $this->messages = $message;

        return true;

    }

    public function addEdit($record,$params=[]){

        return array_merge([
            'api' => route(sprintf(config('table.admin.edit.route','admin.%s.edit'), $this->endpoint), array_merge([$this->alias=>$record['id']], request()->query())),
            'query' => request()->query(),
            'name' => sprintf(config('table.admin.edit.route','admin.%s.edit'), $this->endpoint),
            'object' => [
                'name' => sprintf(config('table.admin.edit.route','admin.%s.edit'), $this->endpoint),
                'params'=>[
                    $this->alias=>$record['id']
                ],
                'query' => request()->query(),
            ],
            'id' => $record['id'],
            'icon' => config('table.admin.edit.icon',"Edit3Icon"),
            'function' =>config('table.admin.edit.function',"editRecord"),
            'sgClass' => config('table.admin.edit.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
        ], $params);
    }


    public function addShow($record,$params=[]){

        return array_merge([
            'api' => route(sprintf(config('table.admin.show.route','admin.%s.show'), $this->endpoint), array_merge([$this->alias=>$record['id']], request()->all())),
            'name' => sprintf(config('table.admin.show.route','admin.%s.show'), $this->endpoint),
            'id' => $record['id'],
            'object' => [
                'name' => sprintf(config('table.admin.show.route','admin.%s.show'), $this->endpoint),
                'params'=>[
                    $this->alias=>$record['id']
                ],
                'query' => request()->query(),
            ],
            'icon' =>config('table.admin.show.icon',"EyeIcon"),
            'function' => config('table.admin.show.function',"showRecord"),
            'sgClass' => config('table.admin.show.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
        ], $params);
    }
}
