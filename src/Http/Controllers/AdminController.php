<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 */

namespace SIGA\Http\Controllers;

use App\Http\Controllers\Controller;
use SIGA\User;

class AdminController extends Controller
{

    protected $model = User::class;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tableView = app($this->model)->render();

        return response()->json($tableView);
    }

    public function  show($id){

        $tableView = app($this->model)->render($id);

        return response()->json($tableView);

    }
}
