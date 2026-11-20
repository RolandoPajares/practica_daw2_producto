<?php

class ErrorController extends Controller
{
    public function error404(): void
    {
        http_response_code(404);
        $this->views->render($this, 'error404', ['title' => 'Página no encontrada', 'message' => 'La ruta solicitada no existe.']);
    }
}
