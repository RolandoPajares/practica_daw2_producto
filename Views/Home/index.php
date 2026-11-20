<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('Assets/css/style.css') ?>">
</head>

<body>
    <main class="container">
        <h1><?= e($title) ?></h1>
        <p><?= e($message) ?></p><a class="button" href="<?= base_url('productos') ?>">Gestionar productos</a>
    </main>
</body>

</html>