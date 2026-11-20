<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('Assets/css/style.css') ?>">
</head>
<body>
    <main class="container form-container">
        <h1><?= e($title) ?></h1>

        <?php if (!empty($error)): ?>
            <p class="error"><?= e($error) ?></p>
        <?php endif; ?>

        <form method="post" action="<?= base_url($action) ?>">
            <label for="id_categoria">Categoría</label>
            
            
            <select id="id_categoria" name="id_categoria" required>
                <option value="">Seleccione...</option>
                <?php foreach ($categorias as $categoria): ?>
                    <?php $isSelected = (string) ($producto['id_categoria'] ?? '') === (string) $categoria['id']; ?>
                    <option value="<?= e($categoria['id']) ?>" <?= $isSelected ? 'selected' : '' ?>>
                        <?= e($categoria['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="id_marca">Marca</label>
            <select id="id_marca" name="id_marca" required>
                <option value="">Seleccione...</option>
                <?php foreach ($marcas as $marca): ?>
                    <?php $isSelected = (string) ($producto['id_marca'] ?? '') === (string) $marca['id']; ?>
                    <option value="<?= e($marca['id']) ?>" <?= $isSelected ? 'selected' : '' ?>>
                        <?= e($marca['nombre']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="codigo">Código</label>
            <input id="codigo" name="codigo" maxlength="30" required value="<?= e($producto['codigo'] ?? '') ?>">

            <label for="nombre">Nombre</label>
            <input id="nombre" name="nombre" maxlength="120" required value="<?= e($producto['nombre'] ?? '') ?>">

            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" maxlength="250"><?= e($producto['descripcion'] ?? '') ?></textarea>

            <div class="grid">
                <div>
                    <label for="precio">Precio</label>
                    <input id="precio" name="precio" type="number" min="0" step="0.01" required value="<?= e($producto['precio'] ?? '') ?>">
                </div>
                <div>
                    <label for="stock">Stock</label>
                    <input id="stock" name="stock" type="number" min="0" step="1" required value="<?= e($producto['stock'] ?? '') ?>">
                </div>
            </div>

            <label for="unidad_medida">Unidad de medida</label>
            <input id="unidad_medida" name="unidad_medida" maxlength="30" required value="<?= e($producto['unidad_medida'] ?? 'UNIDAD') ?>">

            <label for="fecha_registro">Fecha de registro</label>
            <input id="fecha_registro" name="fecha_registro" type="date" required value="<?= e($producto['fecha_registro'] ?? date('Y-m-d')) ?>">

            <div class="form-actions">
                <button class="button" type="submit">Guardar</button>
                <a href="<?= base_url('productos') ?>">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>