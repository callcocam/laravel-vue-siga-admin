<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace App\Suports\Common;



trait Delete
{
    public function deleteBy($model)
    {

           if ($model) {
            if ($model->delete()) {
                $this->results['title'] = 'Operação:';
                $this->results['result'] = true;
                $this->results['table'] = $this->table;
                $this->results['type'] = 'is-danger';
                //$this->messages = sprintf("Realizada com sucesso, registro - %s - foi excluido com sucesso!!", $model->id);
                $this->messages = "Sucesso! O registro foi excluido!!";

                return true;
            }
        }
        $this->results['title'] = 'Operação:';
        $this->results['result'] = false;
        $this->results['table'] = $this->table;
        $this->results['type'] = 'is-danger';
        $this->messages = sprintf("Falhou, não foi possivel encontrar o registro - %s!!", $model->id);

        return false;
    }


    public function deleteAll($data)
    {
        /**
         * @var AbstractModel
         */
        $model = $this->query()->whereIn('id', $data);

        if ($model) {
            $this->results = [
                'model' => $model->delete()
            ];
            $this->messages = "Realizada com sucesso, registros foram excluido com sucesso!!";
            return true;
        }

        $this->results = [
            'tabla' => $this->table,
        ];
        $this->messages = "Falhou, não foi possivel encontrar o(s) registro(s)!!";
        return false;
    }

    public function addDestroy($record,$params=[]){

        return array_merge([
            'api' => route(sprintf(config('table.admin.destroy.route',"admin.%s.destroy"), $this->endpoint), array_merge([$this->alias=>$record['id']], request()->query())),
            'name' => sprintf('admin.%s.destroy', $this->endpoint),
            'id' => $record['id'],
            'object' => [
                'name' => sprintf(config('table.admin.destroy.route',"admin.%s.destroy"), $this->endpoint),
                'params'=>[
                    $this->alias=>$record['id']
                ],
                'query' => request()->query(),
            ],
            'icon' => config('table.admin.destroy.icon',"Trash2Icon"),
            'function' => config('table.admin.destroy.function',"confirmDeleteRecord"),
            'sgClass' => config('table.admin.destroy.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
        ], $params);
    }
}
