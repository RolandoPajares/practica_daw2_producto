<?php

class ProductoModel extends Model
{
    protected string $table = 'producto';

    public function activos(): array
    {
        return $this->select('producto.id, producto.id_categoria, producto.id_marca, producto.codigo, producto.nombre, producto.descripcion, producto.precio, producto.stock, producto.unidad_medida, producto.fecha_registro, c.nombre AS categoria, m.nombre AS marca')
            ->join('categoria c', 'c.id = producto.id_categoria')
            ->join('marca m', 'm.id = producto.id_marca')
            ->where(['producto.estado = :estado'], ['estado' => 1])
            ->orderBy('producto.id', 'DESC')
            ->get();
    }

    
    public function listarConDetalle(): array
    {
        return $this->activos();
    }

    public function findActivo(int $id): ?array
    {
        return $this->where(['id = :id', 'estado = :estado'], ['id' => $id, 'estado' => 1])->first();
    }
}
