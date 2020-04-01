<?php
/**
 * ==============================================================================================================
 *
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 * ==============================================================================================================
 */

namespace SIGA;


use Illuminate\Support\Facades\Facade;

class AutoRoute extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return 'autoRoute';
    }
}
