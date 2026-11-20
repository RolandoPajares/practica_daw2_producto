<?php

require_once 'Config/Config.php';
require_once 'Helpers/Helpers.php';

$url = $_GET['url'] ?? 'Home';
$parts = explode('/', trim($url, '/'));
$controller = !empty($parts[0]) ? ucfirst(strtolower($parts[0])) : 'Home';
$method = $parts[1] ?? 'index';
$params = !empty($parts[2]) ? array_slice($parts, 2) : [];



if ($controller === 'Productos') {
    $controller = 'Producto';
}


require_once 'Libraries/Core/Autoload.php';
require_once 'Libraries/Core/Load.php';
