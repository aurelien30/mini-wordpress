<?php
/**
 * Point d'entrée de l'application
 * 
 * Toutes les requêtes passent par ce fichier grâce au .htaccess
 */

session_start();

// Active l'affichage des erreurs en développement
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Défini le dossier racine de l'application
define('ROOT_PATH', dirname(__DIR__));

spl_autoload_register(function($class){
   $class = str_replace('App\\','',$class);
   $class = str_replace('\\','/',$class);
   $file = ROOT_PATH . '/src/' . $class . '.php';
   if(file_exists($file)){
      require_once $file;
   }
});

// Charge les variables d'environnement du fichier .env
$envFile = ROOT_PATH . '/.env';
if(file_exists($envFile)){
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as line){
        if (strpos(trim($line),'#') === 0){
            continue;
        }

        if (strpos($line,'=') === false){
           list($key, $value) = explode('=', $line, 2);
           $key = trim($key);
           $value = trim($value);
           
           $value = trim($value, '"\'');

           // Définit la variable d'environnement
           putenv("$key=$value");
           $_ENV[$key] = $value;
           
        }
    }
}

require_once ROOT_PATH . '/src/Config/routes.php';

$router->dispatch();