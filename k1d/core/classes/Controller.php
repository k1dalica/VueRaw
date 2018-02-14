<?php

class Controller {
    protected function model($model) {
        require_once 'core/models/' . $model . '.php';
    }
    
    public function view($view, $params = []) {
        require_once 'core/api/' . $view . '.php';
    }
}