<?php


namespace SIGA;


use Illuminate\Database\Eloquent\SoftDeletes;
use SIGA\Processors\AvatarProcessor;
use SIGA\Tenant\BelongsToTenants;
use SIGA\Common\{Update,Create,Delete,Eloquent,Select};

trait TraitModel
{

    use Select,Eloquent,Create,Update,Delete, SoftDeletes,BelongsToTenants;


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

    public function getLinkAttribute(){

        return [
            'edit'=>$this->addEdit(),
            'show'=>$this->addShow(),
            'destroy'=>$this->addDestroy(),
        ];
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function getAvatarAttribute()
    {
        return AvatarProcessor::get($this);
    }

    /**
     * @return \Illuminate\Config\Repository|mixed|string
     */
    public function getCoverAttribute()
    {
        return AvatarProcessor::get($this);
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
