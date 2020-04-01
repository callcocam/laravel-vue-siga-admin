<?php

/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Common;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

trait Helper
{

    public $slug_fixed = false;
    public $floats = ['price'];

    protected function slug(&$input)
    {

        if (!$this->slug_fixed) {

            if (isset($input[Options::DEFAULT_COLUMN_SLUG_ORIGEM])) {

                $input[Options::DEFAULT_COLUMN_SLUG] = Str::slug($input[Options::DEFAULT_COLUMN_SLUG_ORIGEM]);
            }
        }

        return $input;
    }

    protected function convert_date(&$input)
    {
        if (isset($input['date'])) {

            $input['date'] = date_carbom_format($input['date'])->format('Y-m-d');
        }
        if (!isset($input['id'])) {

            $input['created_at'] = date("Y-m-d H:i:s");
            $input['updated_at'] = date("Y-m-d H:i:s");
        } else {
            unset($input['created_at']);
            $input['updated_at'] = date("Y-m-d H:i:s");
        }

        return $input;
    }

    protected function convert_password(&$input)
    {

        if (isset($input['password']) && !empty($input['password'])) {

            $input['password'] = Hash::make($input['password']);

            return $input;
        }

        unset($input['password']);

        return $input;
    }

    protected function initCover(&$input)
    {

        if (!isset($input[Options::DEFAULT_COLUMN_COVER])) {

            return $input;
        }

        if(is_string($input[Options::DEFAULT_COLUMN_COVER])){
            /**
             * @var $fileExist MorphOne
             */
            $fileExist = $this->model->file();
            if ($fileExist->first()) :
                $fileExist->update([
                    'name'=>$input[Options::DEFAULT_COLUMN_COVER]
                ]);
            else :
                $fileExist->create([
                    'name'=>$input[Options::DEFAULT_COLUMN_COVER]
                ]);
            endif;

        }
        return $input;
    }

    protected function initTags(&$input)
    {
        if (!isset($input['tag'])) {

            return $input;
        }

        //REMOVE TODAS AS TAGS
        $this->model->untag();
        //CADASTARS AS NOVAS
        $this->model->tag($input['tag']);

        return $input;
    }

    protected function initStatus(&$input)
    {
        if (!isset($input['status'])) {

            return $input;
        }

        if (!is_array($input['status'])) {

            return $input;
        }

        $status = $input['status'];

        if (!isset($status['value'])) {

            return $input;
        }

        $input['status'] = $status['value'];

        return $input;
    }

    protected function initPermissions(&$input)
    {
        if (!isset($input['permissions'])) {

            return $input;
        }

        //ADD PERMISSIONS
        $this->model->permissions()->sync($input['permissions']);

        return $input;
    }

    protected function initRoles(&$input)
    {
        if (!isset($input['roles'])) {

            return $input;
        }
        //REMOVE TODAS AS TAGS
        $this->model->roles()->sync($input['roles']);

        return $input;
    }

    protected function initTasks(&$input)
    {


        $data = $input;

        unset($data['id']);

        foreach ($data as $key => $value) {

            if (Str::contains($key, "tasks")) {

                $task = array_filter($value);

                if ($task) :
                    array_push($this->fillable, 'company_id', 'uuid');
                    /**
                     * @var $fileExist MorphOne
                     */
                    $tasksExist = $this->model->tasks();

                    if ($current = $tasksExist->where('name', $task['name'])->first()) :
                        $tasksExist->update(array_merge($current->toArray(), $task));
                    else :
                        $tasksExist->create($task);
                    endif;
                endif;
            }
        }


        return $input;
    }


    protected function initAddress(&$input)
    {

        if (!isset($input['address'])) {

            return $input;
        }

        $data = $input;

        unset($data['id']);

        array_push($this->fillable, 'company_id', 'uuid');
        /**
         * @var $fileExist MorphOne
         */
        $addressExist = $this->model->address();

        $data = $input['address'];

        if ($addressExist->first()) :
            $current = $addressExist->first()->toArray();
            $addressExist->update(array_merge($current, $data));
        else :
            $addressExist->create($data);
        endif;

        return $input;
    }


    public function initArray(&$input)
    {

        if ($input) :

            foreach ($input as $key => $value) :

                if (is_array($value)) :

                    if (in_array($key, ['tag'])) :

                    //$input[$key] = json_encode($value);

                    endif;

                endif;

            endforeach;

        endif;

        return $input;
    }

    public function initCod(&$input)
    {

        if (!array_key_exists('codigo', $input)) :

            return $input;

        endif;
        if (empty($input['codigo'])) :
            $cod =  static::withTrashed()->max('codigo');
            if (!$cod) {

                $cod = 0;
            }
            $input['codigo'] = ($cod += 1);
        endif;
        return $input;
    }


    public function initFloat(&$input)
    {

        if ($this->floats) :

            foreach ($this->floats as  $value) {
                if (array_key_exists($value, $input)) :

                    $input[$value] = form_w($input[$value]);

                endif;
            }

        endif;

        return $input;
    }


    protected $titile = 'Lista de Company';

    protected $messages =  'Operação finalizada com sucesso!!';

    /**
     * @return array
     */
    public function getMessage(): string
    {
        return $this->messages;
    }
}
