<?php
/**
 * Created by Claudio Campos.
 * User: callcocam@gmail.com, contato@sigasmart.com.br
 * https://www.sigasmart.com.br
 */
namespace SIGA\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AbstractController extends Controller
{

    protected $model;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tableView=[];

        if(is_string($this->model))
           $tableView = app($this->model)->render();

        return response()->json($tableView);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Illuminate\Http\Response
     */
    public function save($request)
    {

        return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tableView=[];

        if(is_string($this->model))
            $tableView = app($this->model)->render($id);

        return response()->json($tableView);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tableView=[];

        if(is_string($this->model)){

            $model = app($this->model);

            $model->deleteBy($model);

            $tableView = $model->render();
        }


        return response()->json($tableView);
    }
}
