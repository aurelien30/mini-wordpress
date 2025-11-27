<?php

namespace App\Core;

* Controller - Classe de base pour tous les contrôleurs

class Controller{

    /**
     * Affiche une vue avec des données
     * 
     * @param string $view Le nom de la vue (ex: 'home')
     * @param array $data Les données à mettre à la vue
     * 
     * Exemple:
     * $this->view('home', ['title' => 'Accueil', 'user' => $user]);
     */
    protected function view(string $view, array $data = []): void{
         // Extrait les données pour les rendre disponibles comme variables
        // Si $data = ['title' => 'Accueil'], alors $title sera disponible dans la vue
        extract($data);

        // Charge le fichier de vue
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewPath)){
            die("La vue {$view} n'existe pas.");
        }

        require_once $viewPath;
    }

     /**
     * Redirige vers une autre page
     * 
     * @param string $path Le chemin de destination
     * 
     * Exemple:
     * $this->redirect('/login');
     */
    protected function redirect(string $path): void{
        header("Location: {$path}");
        exit;
    }

    protected function json(array $data, int $status = 200): void{
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

     /**
     * Vérifie si la requête est en POST
     * 
     * @return bool True si POST, False sinon
     */
    protected function isPost(): bool{
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * Vérifie si la requête est en GET
     * 
     * @return bool True si GET, False sinon
     */
    protected function isGet(): bool{
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }

    /**
     * Récupère une valeur POST de manière sécurisée
     * 
     * @param string $key La clé à récupérer
     * @param mixed $default Valeur par défaut si la clé n'existe pas
     * @return mixed
     * 
     * Exemple:
     * $email = $this->getPost('email', '');
     */
    protected function getPost(string $key, mixed $default = null){
        return $_POST[$key] ?? $default;
    }

    /**
     * Récupère une valeur GET de manière sécurisée
     * 
     * @param string $key La clé à récupérer
     * @param mixed $default Valeur par défaut
     * @return mixed
     */

protected function getGet(string $key, mixed $default = null){
    return $_GET[$key] ?? $default;
   }
}