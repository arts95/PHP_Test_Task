<?php

ini_set("display_errors", 1);
spl_autoload_register(function ($className) {
    $className = ltrim($className, '\\');
    $fileName = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
    $path = substr($_SERVER['DOCUMENT_ROOT'], 0, -3) . $fileName;
    if (file_exists($path)) {
        require $path;
    }
});

$app = new app\Application();
$app->handle();
