<?php

class CategoriaModel extends Model
{
    protected string $table = 'categoria';

    public function activas(): array
    {
        return $this->select('id, nombre')->where(['estado = :estado'], ['estado' => 1])->orderBy('nombre')->get();
    }
}
    