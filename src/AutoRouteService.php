<?php

/**
 * ==============================================================================================================
 *
 * AutoRouteDbService: Classe para registro de rotas
 *
 * ----------------------------------------------------
 *
 * Created by Claudio Campos.
 * User: callcocam@gmail.com
 * https://www.sigasmart.com.br
 * ==============================================================================================================
 */
namespace SIGA;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

class AutoRouteService
{
   protected $middleware;
   protected $pattern;
    /**
     * @var \Illuminate\Routing\Route
     */
    private $route;

    /**
     * AutoRouteDbService constructor.
     * @param \Illuminate\Routing\Router $route
     */
    public function __construct(Router $route)
   {
       $this->route = $route;
   }

    /**
     * @param $middleware
     * @return AutoRouteService
     */
    public function setMiddleware($middleware)
    {
        $this->middleware = $middleware;

        return $this;
    }

    /**
     * @param $pattern
     * @return AutoRouteService
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    protected function register($router,$route)
    {
        if (!empty($route)) {
            $router->name($route);
        }
        if ($this->middleware) {
            $router->middleware($this->middleware);
        }
        return $router;
    }

    public function resources($path, $resource,$route){
        $this->route->resource($this->pattern($path), $resource)->names([
            'index'=>sprintf('admin.%s.index', $route),
            'create'=>sprintf('admin.%s.create', $route),
            'store'=>sprintf('admin.%s.store', $route),
            'show'=>sprintf('admin.%s.show', $route),
            'edit'=>sprintf('admin.%s.edit', $route),
            'update'=>sprintf('admin.%s.update', $route),
            'destroy'=>sprintf('admin.%s.destroy', $route),
        ])->parameters([
            $route => 'id'
        ]);

        if ($this->middleware) {
            $this->route->middleware($this->middleware);
        }
        $this->print($path, $resource,$route);
        $this->find($path, $resource,$route);
        $this->upload($path, $resource,$route);
        $this->remove_file($path, $resource,$route);
    }

    /**
     * @param $path /posts
     * @param $controller PostController
     * @param string $method index
     * @param string $route post
     * @return mixed
     */
    public function post($path, $controller, $method='index', $route=''){
        $router = $this->route->post($this->pattern($path), sprintf("%s@%s", $controller, $method));
        return $this->register($router,$route);

    }

    /**
     * @param $path /posts
     * @param $controller PostController
     * @param string $method index
     * @param string $route post
     * @return mixed
     */
    public function put($path,$controller,$method='index',$route=''){
        $router = $this->route->put($this->pattern($path), sprintf("%s@%s", $controller, $method));
        return $this->register($router,$route);
    }

    /**
     * @param $path /posts
     * @param $controller PostController
     * @param string $method index
     * @param string $route post
     * @return mixed
     */
    public function delete($path,$controller,$method='index',$route=''){
        $router = $this->route->delete($this->pattern($path), sprintf("%s@%s", $controller, $method));
        return $this->register($router,$route);
    }

    /**
     * @param $path /posts
     * @param $controller PostController
     * @param string $method index
     * @param string $route post
     * @return mixed
     */
    public function any($path,$controller,$method,$route=''){
        $router = $this->route->any($this->pattern($path), sprintf("%s@%s", $controller, $method));
        return $this->register($router,$route);
    }

    /**
     * @param $path /posts
     * @param $controller PostController
     * @param string $method index
     * @param string $route post
     * @return mixed
     */
    public function get($path,$controller,$method='index',$route=''){
        $router = $this->route->get($this->pattern($path), sprintf("%s@%s", $controller, $method));
        return $this->register($router,$route);
    }

    private function upload($path, $controller,$route){
        $this->route->post(sprintf("%s/upload",$path), sprintf("%s@%s", $controller, "upload"))
            ->name(sprintf('admin.%s.upload', $route));
        if ($this->middleware) {
            $this->route->middleware($this->middleware);
        }
    }

    private function remove_file($path, $controller,$route){
        $this->route->post(sprintf("%s/remove-file",$path), sprintf("%s@%s", $controller, "remove_file"))
            ->name(sprintf('admin.%s.remove-file', $route));
        if ($this->middleware) {
            $this->route->middleware($this->middleware);
        }
    }

    private function print($path, $controller,$route){
        $this->route->get(sprintf("%s/{id}/imprimir",$path), sprintf("%s@%s", $controller, "print"))
            ->name(sprintf('admin.%s.print', $route));
        if ($this->middleware) {
            $this->route->middleware($this->middleware);
        }
    }
    private function find($path, $controller,$route){
        $this->route->get(sprintf("%s/find/select",$path), sprintf("%s@%s", $controller, "find"))
            ->name(sprintf('admin.%s.find', $route));
        if ($this->middleware) {
            $this->route->middleware($this->middleware);
        }
    }

    private function pattern($resource){

        if(!empty($this->pattern)){
          return sprintf("%s/%s", $resource, $this->pattern);
        }

        return $resource;
    }


}
