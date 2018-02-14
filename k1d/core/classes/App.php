<?php

class App {
    protected $controller;
    protected $method = 'err';
    protected $prams = [];
    protected $index = 'index.html';
    
    public function __construct() {
        $url = $this->parseUrl();
        if($url[0] == "api" && isset($url[1])) {
            unset($url[0]);    
            require_once 'core/Controller.php';
            $this->controller = new Api();
            
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
            
            /* Disable on live */
            header("Access-Control-Allow-Origin: *");
            header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");

            header('Content-Type: application/json');
            $this->prams = $url ? array_values($url) : [] ;
            call_user_func_array([$this->controller, $this->method], $this->prams);
        } else {
            require_once $this->index;
        }
    }
    
    protected function parseUrl() {
        if(isset($_GET['url'])) {
            return $url = explode('/',filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }
}
