<?php

class Controller
{
    protected Views $views;
    protected ?Model $model = null;

    public function __construct()
    {
        $this->views = new Views();
        $this->loadModel();
    }

    protected function loadModel(): void
    {
        $modelName = str_replace('Controller', 'Model', get_class($this));
        $path = 'Models/' . $modelName . '.php';
        if (file_exists($path)) {
            require_once $path;
            $this->model = new $modelName();
        }
    }
}
