<?php

class HomeController extends Controller
{
    public function index(): void
    {
        $this->views->render($this, 'index', [
            'title' => 'CRUD de Productos',
            'message' => 'PHP nativo, arquitectura MVC, PDO y ORM propio.'
        ]);
    }
}
