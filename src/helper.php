<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

if (!function_exists('siga_path')){

    function siga_path($path=""){

        return sprintf("%s/%s",__DIR__, $path);
    }
}

if (! function_exists('tableView')) {
    /**
     * @param \Illuminate\Support\Collection|\Illuminate\Database\Eloquent\Builder $data
     * @return \SIGA\TableView\TableView
     */
    function tableView($data)
    {
        return new SIGA\TableView\TableView($data);
    }
}
