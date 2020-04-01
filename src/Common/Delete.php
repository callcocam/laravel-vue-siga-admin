<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Common;



use SIGA\TraitModel;

trait Delete
{
    public function deleteBy($model)
    {
        /**
         * @var TraitModel $model
         */
        if ($model) {
            if ($model->delete()) {
                return $this->setMessages(true,'destroy');
            }
        }
        return $this->setMessages(false,'destroy');
    }


    public function deleteAll($data)
    {
        /**
         * @var TraitModel $model
         */
        $model = $this->query()->whereIn('id', $data);

        if ($model) {
            $this->results = [
                'model' => $model->delete()
            ];
            return $this->setMessages(true,'destroy');
        }

        return $this->setMessages(false,'destroy');
    }

    public function addDestroy($params=[]){

        return array_merge([
            'api' => route(sprintf(config('siga.table.admin.destroy.route',"admin.%s.destroy"), $this->getTable()), array_merge([$this->getKeyName()=>$this->getKey()], request()->query())),
            'name' => sprintf('admin.%s.destroy', $this->getTable()),
            'id' => $this->getKey(),
            'object' => [
                'name' => sprintf(config('siga.table.admin.destroy.route',"admin.%s.destroy"), $this->getTable()),
                'params'=>[
                    $this->getKeyName()=>$this->getKey()
                ],
                'query' => request()->query(),
            ],
            'icon' => config('siga.table.admin.destroy.icon',"Trash2Icon"),
            'function' => config('siga.table.admin.destroy.function',"confirmDeleteRecord"),
            'sgClass' => config('siga.table.admin.destroy.class',"h-5 w-5 mr-4 hover:text-primary cursor-pointer"),
        ], $params);
    }

    private function messageDestroy($result){

        $this->results['title'] = config('siga.admin.table.destroy.messages.title','Operação:');
        if($result){
            $this->results['result'] = $result;
            $this->results['type'] = config('siga.admin.table.destroy.messages.type.success','success:');
            $this->results['redirect'] = $this->addIndex();
            $this->results['messages'] =  config('siga.admin.table.destroy.messages.success',"Realizada com sucesso, registro foi excluido com sucesso!!");
            return $result;
        }

        $this->results['result'] = $result;
        $this->results['type'] = config('siga.admin.table.destroy.messages.type.success','danger:');
        $this->results['messages'] =  sprintf(config('siga.admin.table.destroy.messages.message',"Falhou, não foi possivel encontrar o registro - %s!!"), $this->getKey());
        return $result;
    }
}
