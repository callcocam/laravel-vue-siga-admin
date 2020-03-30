<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */

if (!function_exists('siga_path')){

    function siga_path($path=""){

        return sprintf("%s/callcocam/siga/src/%s",__DIR__, $path);
    }
}
