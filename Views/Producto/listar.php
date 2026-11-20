<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos activos</title>
    <link rel="stylesheet" href="<?= base_url('Assets/css/style.css') ?>">
</head>

<body>
    <main class="container wide">
        <div class="topbar">
            <h1>Productos activos</h1><a class="button" href="<?= base_url('productos/crear') ?>">+ Nuevo producto</a>
        </div>
        <p><a href="<?= base_url() ?>">Inicio</a> | <a href="<?= base_url('productos') ?>">Productos</a></p>
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Marca</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Unidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$productos): ?><tr>
                        <td colspan="8">No hay productos activos.</td>
                    </tr><?php endif; ?>
                <?php foreach ($productos as $producto): ?><tr>
                        <td><?= e($producto['codigo']) ?></td>
                        <td><?= e($producto['nombre']) ?><br><small><?= e($producto['descripcion']) ?></small></td>
                        <td><?= e($producto['categoria']) ?></td>
                        <td><?= e($producto['marca']) ?></td>
                        <td>S/ <?= number_format((float)$producto['precio'], 2) ?></td>
                        <td><?= e($producto['stock']) ?></td>
                        <td><?= e($producto['unidad_medida']) ?></td>
                        <td class="actions"><a href="<?= base_url('productos/editar/' . $producto['id']) ?>">Editar</a>
                            <form method="post" action="<?= base_url('productos/eliminar/' . $producto['id']) ?>" onsubmit="return confirm('¿Desactivar este producto?');"><button class="link-button" type="submit">Eliminar</button></form>
                        </td>
                    </tr><?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>

</html>