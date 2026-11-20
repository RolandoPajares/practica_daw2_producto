<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title><?= e($title) ?></title>
    <link rel="stylesheet" href="<?= base_url('Assets/css/style.css') ?>">
</head>

<body>
    <main class="container">
        <h1><?= e($title) ?></h1>
        <p><?= e($message) ?></p><a href="<?= base_url() ?>">Volver al inicio</a>
    </main>
</body>

</html>