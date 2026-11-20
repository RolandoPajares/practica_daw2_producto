<?php

class Views
{
    public function render(object $controller, string $view, array $data = []): void
    {
        $controllerName = str_replace('Controller', '', get_class($controller));
        $path = "Views/{$controllerName}/{$view}.php";
        if (!file_exists($path)) {
            require_once 'Controllers/ErrorController.php';
            (new ErrorController())->error404();
            return;
        }
        extract($data);
        require_once $path;
    }
}
