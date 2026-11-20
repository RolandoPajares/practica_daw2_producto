<?php

class MarcaModel extends Model
{
    protected string $table = 'marca';

    public function activas(): array
    {
        return $this->select('id, nombre')->where(['estado = :estado'], ['estado' => 1])->orderBy('nombre')->get();
    }
}
